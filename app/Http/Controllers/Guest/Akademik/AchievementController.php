<?php

namespace App\Http\Controllers\Guest\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Information;

class AchievementController extends Controller
{
    public function prestasi()
    {
        $achievements = Achievement::where('active', 1)->latest()->paginate(15);
        $newsPrestasi = Information::news()->active()->where('title', 'LIKE', '%Prestasi%')->latest()->get();
        return view('guest.prestasi', compact('achievements', 'newsPrestasi'));
    }
}