<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class ToolController extends Controller 
{
    /**
     * Menampilkan daftar alat dengan pagination agar seragam dengan yang lain
     */
    public function index(Request $request) 
    {
        $query = Tool::with('lab');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $tools = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.tool.index', compact('tools'));
    }

    public function create() 
    {
        $labs = Lab::where('active', 1)->orderBy('name')->get();
        return view('admin.tool.create', compact('labs'));
    }

    /**
     * Simpan alat baru dengan Transaksi & Error Handling
     */
    public function store(Request $request) 
    {
        $request->validate([
            'lab_id'      => 'required|exists:labs,id',
            'code'        => 'required|unique:tools,code',
            'name'        => 'required|string|max:255',
            'stock_total' => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['created_by']    = Auth::id();
            $data['active']        = $request->boolean('active', true);
            $data['is_borrowable'] = $request->has('is_borrowable'); 

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('tools', 'public');
            }

            Tool::create($data);

            DB::commit();
            return redirect()->route('tools.index')->with('success', 'Alat berhasil ditambahkan ke katalog.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan alat: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit(Tool $tool) 
    {
        $labs = Lab::where('active', 1)->orderBy('name')->get();
        return view('admin.tool.edit', compact('tool', 'labs'));
    }

    /**
     * Update data alat dengan pembersihan file lama
     */
    public function update(Request $request, Tool $tool) 
    {
        $request->validate([
            'lab_id'      => 'required|exists:labs,id',
            'code'        => 'required|unique:tools,code,' . $tool->id,
            'name'        => 'required|string|max:255',
            'stock_total' => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['updated_by']    = Auth::id();
            $data['active']        = $request->boolean('active');
            $data['is_borrowable'] = $request->has('is_borrowable');

            if ($request->hasFile('image')) {
                // Hapus foto lama jika ada foto baru
                if ($tool->image && Storage::disk('public')->exists($tool->image)) {
                    Storage::disk('public')->delete($tool->image);
                }
                $data['image'] = $request->file('image')->store('tools', 'public');
            }

            $tool->update($data);

            DB::commit();
            return redirect()->route('tools.index')->with('success', 'Data alat berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal update alat: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Hapus alat sekaligus file gambarnya
     */
    public function destroy(Tool $tool) 
    {
        DB::beginTransaction();
        try {
            if ($tool->image && Storage::disk('public')->exists($tool->image)) {
                Storage::disk('public')->delete($tool->image);
            }

            $tool->delete();

            DB::commit();
            return redirect()->route('tools.index')->with('success', 'Alat berhasil dihapus dari sistem.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal hapus alat: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}