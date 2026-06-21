<?php

namespace App\Http\Controllers\Guest\Profil;

use App\Http\Controllers\Controller;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function profilBioproses()
    {
        $profiles = Profile::where('active', 1)->where('key', 'LIKE', 'P_%')->orderBy('id', 'asc')->get();
        return view('guest.profil', compact('profiles'));
    }

    public function beasiswa()
    {
        $data = Profile::where('key', 'A_BEASISWA')->where('active', 1)->firstOrFail();
        return view('guest.beasiswa', compact('data'));
    }
}