<?php

namespace App\Http\Controllers\Guest\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Subject;

class CurriculumController extends Controller
{
    public function kurikulum()
    {
        $curriculum = Curriculum::where('active', 1)->first();
        $subjects = $curriculum ? Subject::where('curriculum_id', $curriculum->id)->where('active', 1)->orderBy('semester', 'asc')->get() : collect();
        return view('guest.kurikulum', compact('curriculum', 'subjects'));
    }
}