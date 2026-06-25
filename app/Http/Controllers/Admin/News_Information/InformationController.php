<?php

namespace App\Http\Controllers\Admin\News_Information;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

/**
 * Class InformationController
 *
 * Mengelola berita (news) dan pengumuman (announcement).
 * Mendukung CRUD dengan upload gambar dan lampiran file,
 * serta validasi khusus untuk masing-masing tipe.
 */
class InformationController extends Controller
{

    private function authorizeRole(array $roles): void
    {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang diizinkan.');
        }
    }
    /**
     * Menampilkan daftar informasi dengan fitur pencarian & filter.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Information::with('creator');

        // Filter berdasarkan pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        
        // Filter berdasarkan Tipe (News/Announcement)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan Kategori (Mahasiswa/Dosen/Umum)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }

        $informations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.informations.index', compact('informations'));
    }

    /**
     * Menampilkan form tambah informasi.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.informations.create');
    }

    /**
     * Menyimpan data informasi baru dengan transaksi database.
     * Penanganan khusus untuk tipe news dan announcement.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi dasar
        $rules = [
            'type'    => 'required|in:news,announcement',
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Validasi tambahan berdasarkan tipe
        if ($request->type === 'news') {
            $rules['category']     = 'required|in:Kegiatan Mahasiswa,Kegiatan Dosen,Kegiatan Umum';
            $rules['published_at'] = 'required|date';
        } else {
            $rules['attachment_file'] = 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120';
            $rules['expired_at']      = 'nullable|date';
        }

        $validated = $request->validate($rules);

        // 2. Mulai Transaksi
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['active']       = $request->boolean('active', true);
            $data['is_important'] = $request->boolean('is_important', false);
            $data['created_by']   = Auth::id();

            // Set field default berdasarkan tipe
            if ($request->type === 'announcement') {
                $data['category'] = 'Pengumuman';
                $data['published_at'] = null;
            } else {
                $data['attachment_file'] = null;
                $data['expired_at'] = null;
            }

            // --- Upload file sebelum simpan ---

            // Handle Upload Foto
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('informations/images', 'public');
            }

            // Handle Upload Dokumen (hanya untuk announcement)
            if ($request->type === 'announcement' && $request->hasFile('attachment_file')) {
                $data['attachment_file'] = $request->file('attachment_file')->store('informations/docs', 'public');
            }

            // SIMPAN HANYA SATU KALI
            Information::create($data);

            DB::commit(); 
            return redirect()->route('informations.index')->with('success', 'Informasi baru berhasil diterbitkan!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan informasi: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    /**
     * Menampilkan form edit informasi.
     *
     * @param Information $information
     * @return \Illuminate\View\View
     */
    public function edit(Information $information)
    {
        return view('admin.informations.edit', compact('information'));
    }

    /**
     * Memperbarui data informasi dengan pembersihan file lama.
     *
     * @param Request $request
     * @param Information $information
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Information $information)
    {
        // Validasi input
        $rules = [
            'type'    => 'required|in:news,announcement',
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        if ($request->type === 'news') {
            $rules['category'] = 'required';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['active']       = $request->boolean('active');
            $data['is_important'] = $request->boolean('is_important');
            $data['updated_by']   = Auth::id();

            // Update Foto & Hapus yang lama jika ada
            if ($request->hasFile('image')) {
                if ($information->image) {
                    Storage::disk('public')->delete($information->image);
                }
                $data['image'] = $request->file('image')->store('informations/images', 'public');
            }

            // Update Dokumen
            if ($request->hasFile('attachment_file')) {
                if ($information->attachment_file) {
                    Storage::disk('public')->delete($information->attachment_file);
                }
                $data['attachment_file'] = $request->file('attachment_file')->store('informations/docs', 'public');
            }

            $information->update($data);

            DB::commit();
            return redirect()->route('informations.index')->with('success', 'Informasi berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update Gagal: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Menghapus informasi beserta file fisik terkait.
     *
     * @param Information $information
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Information $information)
    {
        try {
            // Hapus file fisik agar tidak memenuhi server
            if ($information->image) {
                Storage::disk('public')->delete($information->image);
            }
            if ($information->attachment_file) {
                Storage::disk('public')->delete($information->attachment_file);
            }
            
            $information->delete();
            return redirect()->route('informations.index')->with('success', 'Data informasi berhasil dihapus.');
        } catch (Exception $e) {
            Log::error('Hapus Gagal: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}