<?php

namespace App\Http\Controllers\Guest\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;

class LecturerController extends Controller
{
    public function dosenStaff()
    {
        $allPersonel = Lecturer::where('active', 1)->get();
        $hierarchy = ['Guru Besar'=>1,'Lektor Kepala'=>2,'Lektor'=>3,'Asisten Ahli'=>4,'Tenaga Pengajar'=>5,'Teaching Assistant'=>6,'Staff Administrasi'=>7,'Laboran'=>8,'Teknisi'=>9,'Lainnya'=>10];
        $sorted = $allPersonel->sortBy(fn($item) => [$hierarchy[$item->academic_position] ?? 99, $item->name])->values();
        
        $groups = [
            'Dosen' => ['Guru Besar','Lektor Kepala','Lektor','Asisten Ahli','Tenaga Pengajar'],
            'Teaching Assistant' => ['Teaching Assistant'],
            'Staff' => ['Staff Administrasi','Laboran','Teknisi','Lainnya']
        ];

        $grouped = [];
        foreach ($groups as $name => $pos) {
            $data = $sorted->filter(fn($item) => in_array($item->academic_position, $pos))->values();
            if ($data->count() > 0) $grouped[$name] = $data;
        }

        return view('guest.profil_dosen_staff', ['grouped' => $grouped, 'totalCount' => $allPersonel->count(), 'others' => collect()]);
    }

    public function lecturerDetail($id)
    {
        $person = Lecturer::with(['educations', 'achievements'])->findOrFail($id);
        return view('guest.profil_dosen_detail', compact('person'));
    }
}