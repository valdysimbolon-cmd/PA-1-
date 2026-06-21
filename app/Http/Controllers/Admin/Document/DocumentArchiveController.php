<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Class DocumentArchiveController
 *
 * Mengelola arsip dokumen (PDF, Word, Excel) dengan fitur:
 * - Upload file ke storage
 * - Manajemen tag (preset + custom)
 * - Filter berdasarkan tahun dan tag
 * - Kontrol akses unduh berdasarkan role
 * - Penanganan file secara transaksional untuk mencegah orphan file
 */
class DocumentArchiveController extends Controller
{
    // -------------------------------------------------------------------------
    // READ — Menampilkan Data
    // -------------------------------------------------------------------------

    /**
     * Menampilkan daftar dokumen dengan filter pencarian, tahun, dan tag.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = DocumentArchive::with(['creator', 'updater']);

        // Filter pencarian (judul atau deskripsi)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tahun (jika ada input year)
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter berdasarkan tag (menggunakan JSON contains)
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();
        $presetTags = DocumentArchive::PRESET_TAGS;

        return view('admin.document_archive.index', compact('documents', 'presetTags'));
    }

    /**
     * Menampilkan form tambah dokumen.
     *
     * @return View
     */
    public function create(): View
    {
        $presetTags = DocumentArchive::PRESET_TAGS;

        return view('admin.document_archive.create', compact('presetTags'));
    }

    /**
     * Menampilkan form edit dokumen.
     *
     * @param DocumentArchive $documentArchive
     * @return View
     */
    public function edit(DocumentArchive $documentArchive): View
    {
        $presetTags = DocumentArchive::PRESET_TAGS;

        return view('admin.document_archive.edit', compact('documentArchive', 'presetTags'));
    }

    // -------------------------------------------------------------------------
    // CREATE (Menyimpan Data Baru)
    // -------------------------------------------------------------------------

    /**
     * Menyimpan dokumen baru ke database dan storage.
     * Menggunakan transaksi untuk memastikan konsistensi DB dan file.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',           // terima preset + custom
            'file'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'year'        => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'description' => 'nullable|string|max:65000',
            'active'      => 'nullable|boolean',
        ]);

        $filePath = null;

        try {
            // Upload file di luar transaction agar tidak menahan koneksi DB
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('archives', 'public');

                if (! $filePath) {
                    throw new \RuntimeException('Gagal menyimpan file ke storage.');
                }
            }

            DB::transaction(function () use ($validated, $filePath, $request) {
                // Gabungkan tag preset + custom, buang duplikat, reset index
                $tags = collect($validated['tags'] ?? [])
                    ->map(fn($t) => trim($t))
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                DocumentArchive::create([
                    'title'       => $validated['title'],
                    'tags'        => $tags ?: null,
                    'file_path'   => $filePath,
                    'year'        => $validated['year'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'active'      => $request->boolean('active', true),
                    'created_by'  => auth()->id(),
                    'updated_by'  => auth()->id(),
                ]);
            });

            return redirect()
                ->route('document_archives.index')
                ->with('success', 'Dokumen berhasil disimpan!');

        } catch (\Throwable $e) {
            // Rollback file jika DB gagal — cegah orphan file di storage
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            Log::error('DocumentArchive store failed', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan dokumen. Silakan coba lagi.');
        }
    }

    // -------------------------------------------------------------------------
    // UPDATE (Memperbarui Data)
    // -------------------------------------------------------------------------

    /**
     * Memperbarui data dokumen yang sudah ada.
     * Jika ada file baru, file lama akan dihapus setelah transaksi DB berhasil.
     *
     * @param Request $request
     * @param DocumentArchive $documentArchive
     * @return RedirectResponse
     */
    public function update(Request $request, DocumentArchive $documentArchive): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
            'file'        => 'nullable|file|mimes:pdf,docx,xlsx|max:10240',
            'year'        => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'description' => 'nullable|string|max:65000',
            'active'      => 'nullable|boolean',
        ]);

        $newFilePath = null;
        $oldFilePath = $documentArchive->file_path;

        try {
            // Upload file baru sebelum membuka transaction
            if ($request->hasFile('file')) {
                $newFilePath = $request->file('file')->store('archives', 'public');

                if (! $newFilePath) {
                    throw new \RuntimeException('Gagal menyimpan file baru ke storage.');
                }
            }

            DB::transaction(function () use ($validated, $newFilePath, $request, $documentArchive) {
                $tags = collect($validated['tags'] ?? [])
                    ->map(fn($t) => trim($t))
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                $documentArchive->update([
                    'title'       => $validated['title'],
                    'tags'        => $tags ?: null,
                    'file_path'   => $newFilePath ?? $documentArchive->file_path,
                    'year'        => $validated['year'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'active'      => $request->boolean('active'),
                    'updated_by'  => auth()->id(),
                ]);
            });

            // Hapus file lama SETELAH DB berhasil diupdate
            if ($newFilePath && $oldFilePath) {
                Storage::disk('public')->delete($oldFilePath);
            }

            return redirect()
                ->route('document_archives.index')
                ->with('success', 'Dokumen berhasil diperbarui!');

        } catch (\Throwable $e) {
            // Rollback file baru jika DB gagal
            if ($newFilePath) {
                Storage::disk('public')->delete($newFilePath);
            }

            Log::error('DocumentArchive update failed', [
                'user_id'     => auth()->id(),
                'document_id' => $documentArchive->id,
                'error'       => $e->getMessage(),
                'trace'       => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui dokumen. Silakan coba lagi.');
        }
    }

    // -------------------------------------------------------------------------
    // DELETE (Menghapus Data)
    // -------------------------------------------------------------------------

    /**
     * Menghapus dokumen dari database dan file fisik dari storage.
     *
     * @param DocumentArchive $documentArchive
     * @return RedirectResponse
     */
    public function destroy(DocumentArchive $documentArchive): RedirectResponse
    {
        $filePath = $documentArchive->file_path;

        try {
            DB::transaction(function () use ($documentArchive) {
                $documentArchive->delete();
            });

            // Hapus file SETELAH record DB berhasil dihapus
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->with('success', 'Dokumen berhasil dihapus!');

        } catch (\Throwable $e) {
            Log::error('DocumentArchive destroy failed', [
                'user_id'     => auth()->id(),
                'document_id' => $documentArchive->id,
                'error'       => $e->getMessage(),
                'trace'       => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Gagal menghapus dokumen. Silakan coba lagi.');
        }
    }

    // -------------------------------------------------------------------------
    // DOWNLOAD — dengan kontrol akses berdasarkan role
    // -------------------------------------------------------------------------

    /**
     * Mengunduh file dokumen dengan pengecekan hak akses (berdasarkan role user).
     *
     * @param DocumentArchive $documentArchive
     * @return mixed (Stream download atau redirect dengan error)
     */
    public function download(DocumentArchive $documentArchive): mixed
    {
        // Cek apakah dokumen punya file
        if (! $documentArchive->hasFile()) {
            return back()->with('error', 'File dokumen tidak tersedia.');
        }

        // Cek hak akses user — guest & role tidak dikenal ditolak
        if (! $documentArchive->canBeDownloadedBy(auth()->user())) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh dokumen ini.');
        }

        try {
            return Storage::disk('public')->download(
                $documentArchive->file_path,
                $documentArchive->title . '.' . $documentArchive->file_extension
            );
        } catch (\Throwable $e) {
            Log::error('DocumentArchive download failed', [
                'user_id'     => auth()->id(),
                'document_id' => $documentArchive->id,
                'error'       => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengunduh file. Silakan coba lagi.');
        }
    }
}