<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class InformationController extends Controller
{
    /**
     * Menampilkan daftar informasi dengan fitur pencarian & filter
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

        $informations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.informations.index', compact('informations'));
    }

    public function create()
    {
        return view('admin.informations.create');
    }

    /**
     * Menyimpan data baru dengan Transaksi Database
     */
public function store(Request $request)
{
    // 1. Validasi
    $rules = [
        'type'    => 'required|in:news,announcement',
        'title'   => 'required|string|max:255',
        'content' => 'required',
        'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ];

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

        // Logika Kategori & Tanggal
        if ($request->type === 'announcement') {
            $data['category'] = 'Pengumuman';
            $data['published_at'] = null;
        } else {
            $data['attachment_file'] = null;
            $data['expired_at'] = null;
        }

        // --- PROSES FILE DULU BARU SIMPAN ---

        // Handle Upload Foto
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('informations/images', 'public');
        }

        // Handle Upload Dokumen
        if ($request->type === 'announcement' && $request->hasFile('attachment_file')) {
            $data['attachment_file'] = $request->file('attachment_file')->store('informations/docs', 'public');
        }

        // SIMPAN HANYA SATU KALI DI SINI
        Information::create($data);

        DB::commit(); 
        return redirect()->route('informations.index')->with('success', 'Informasi baru berhasil diterbitkan!');

    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Gagal simpan informasi: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
    }
}

    public function edit(Information $information)
    {
        return view('admin.informations.edit', compact('information'));
    }

    /**
     * Update data dengan pembersihan file lama
     */
    public function update(Request $request, Information $information)
    {
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

            // Update Foto & Hapus yang lama jika ada yang baru
            if ($request->hasFile('image')) {
                if ($information->image) Storage::disk('public')->delete($information->image);
                $data['image'] = $request->file('image')->store('informations/images', 'public');
            }

            // Update Dokumen
            if ($request->hasFile('attachment_file')) {
                if ($information->attachment_file) Storage::disk('public')->delete($information->attachment_file);
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
     * Hapus data sekaligus file fisiknya
     */
    public function destroy(Information $information)
    {
        try {
            // Hapus file fisik agar tidak memenuhi server
            if ($information->image) Storage::disk('public')->delete($information->image);
            if ($information->attachment_file) Storage::disk('public')->delete($information->attachment_file);
            
            $information->delete();
            return redirect()->route('informations.index')->with('success', 'Data informasi berhasil dihapus.');
        } catch (Exception $e) {
            Log::error('Hapus Gagal: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}