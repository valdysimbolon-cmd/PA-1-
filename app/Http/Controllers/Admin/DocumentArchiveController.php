<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;
use Illuminate\Http\Request;

class DocumentArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate(['title' => 'required', 'file_path' => 'required|mimes:pdf|max:5120', 'year' => 'required']);
        $data = $request->all();
        if ($request->hasFile('file_path')) { $data['file_path'] = $request->file('file_path')->store('archives', 'public'); }
        DocumentArchive::create($data);
        return redirect()->route('document_archives.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentArchive $documentArchive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentArchive $documentArchive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentArchive $documentArchive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentArchive $documentArchive)
    {
        //
    }
}
