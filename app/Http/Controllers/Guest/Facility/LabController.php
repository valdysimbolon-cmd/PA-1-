<?php

namespace App\Http\Controllers\Guest\Facility;

use App\Http\Controllers\Controller;
use App\Models\Lab;

class LabController extends Controller
{
    public function allLabs()
    {
        $labs = Lab::where('active', 1)->get();
        return view('guest.lab_index', compact('labs'));
    }

    public function showLab($id)
    {
        $lab = Lab::with('inventories')->where('id', $id)->where('active', 1)->firstOrFail();
        return view('guest.lab_detail', compact('lab'));
    }
}