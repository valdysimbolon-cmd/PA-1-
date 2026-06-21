<?php

namespace App\Http\Controllers\Guest\Document;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;

class DocumentArchiveController extends Controller
{
    public function archives()
    {
        $archives = DocumentArchive::where('active', 1)->orderBy('year', 'desc')->orderBy('title', 'asc')->get();
        return view('guest.dokumen', compact('archives'));
    }
}