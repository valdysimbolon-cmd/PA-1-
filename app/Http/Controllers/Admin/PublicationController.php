<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Lecturer;
use App\Models\PublicationAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::with('authors.lecturer')->latest()->get();
        return view('admin.publication.index', compact('publications'));
    }

    public function create()
    {
        $lecturers = Lecturer::where('active', 1)->orderBy('name', 'asc')->get();
        return view('admin.publication.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:500',
            'type'        => 'required',
            'year'        => 'required|digits:4',
            'member_ids'  => 'required|array|min:1',
            'link'        => 'nullable|url'
        ]);

        DB::beginTransaction();
        try {
            $pub = Publication::create([
                'title'     => $request->title,
                'type'      => $request->type,
                'publisher' => $request->publisher,
                'year'      => $request->year,
                'link'      => $request->link,
                'active'    => $request->boolean('active'),
            ]);

            foreach ($request->member_ids as $index => $lecturer_id) {
                if (!empty($lecturer_id)) {
                    PublicationAuthor::create([
                        'publication_id' => $pub->id,
                        'author_id'      => $lecturer_id,
                        'author_type'    => 'App\Models\Lecturer', // Namespace lengkap untuk Polymorphic
                        'position'       => $request->positions[$index] ?? 'Penulis',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('publications.index')->with('success', 'Publikasi karya berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal simpan publikasi: " . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function edit(Publication $publication)
    {
        $lecturers = Lecturer::orderBy('name', 'asc')->get();
        $publication->load('authors'); 
        return view('admin.publication.edit', compact('publication', 'lecturers'));
    }

    public function update(Request $request, Publication $publication)
    {
        $request->validate([
            'title'      => 'required|string|max:500',
            'member_ids' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $publication->update([
                'title'     => $request->title,
                'type'      => $request->type,
                'publisher' => $request->publisher,
                'year'      => $request->year,
                'link'      => $request->link,
                'active'    => $request->boolean('active'),
            ]);

            $publication->authors()->delete();

            foreach ($request->member_ids as $index => $lecturer_id) {
                if (!empty($lecturer_id)) {
                    PublicationAuthor::create([
                        'publication_id' => $publication->id,
                        'author_id'      => $lecturer_id,
                        'author_type'    => 'App\Models\Lecturer',
                        'position'       => $request->positions[$index] ?? 'Penulis',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('publications.index')->with('success', 'Data diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();
        return redirect()->route('publications.index')->with('success', 'Data dihapus.');
    }
}