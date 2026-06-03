<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentArchiveController extends Controller
{
    public function index() {
        $documents = DocumentArchive::latest()->get();
        return view('admin.document_archive.index', compact('documents'));
    }

    public function create() {
        return view('admin.document_archive.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:10240', // Maks 10MB
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['active'] = $request->boolean('active', true);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('archives', 'public');
        }

        DocumentArchive::create($data);
        return redirect()->route('document_archives.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function edit(DocumentArchive $documentArchive) {
        return view('admin.document_archive.edit', compact('documentArchive'));
    }

    public function update(Request $request, DocumentArchive $documentArchive) {
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('file')) {
            if ($documentArchive->file_path) Storage::disk('public')->delete($documentArchive->file_path);
            $data['file_path'] = $request->file('file')->store('archives', 'public');
        }

        $documentArchive->update($data);
        return redirect()->route('document_archives.index')->with('success', 'Dokumen diperbarui!');
    }

    public function destroy(DocumentArchive $documentArchive) {
        if ($documentArchive->file_path) Storage::disk('public')->delete($documentArchive->file_path);
        $documentArchive->delete();
        return back()->with('success', 'Dokumen dihapus!');
    }
}