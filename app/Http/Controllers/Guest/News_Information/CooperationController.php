<?php

namespace App\Http\Controllers\Guest\News_Information;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;

class CooperationController extends Controller
{
    public function allMitra()
    {
        $mitras = Cooperation::where('active', 1)->orderBy('name', 'asc')->paginate(12);
        return view('guest.mitra', compact('mitras'));
    }

    public function showMitra($id)
    {
        $mitra = Cooperation::findOrFail($id);
        return view('guest.mitra_detail', compact('mitra'));
    }
}