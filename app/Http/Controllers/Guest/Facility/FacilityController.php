<?php

namespace App\Http\Controllers\Guest\Facility;

use App\Http\Controllers\Controller;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function allFacilities()
    {
        $facilities = Facility::where('active', 1)->orderBy('name', 'asc')->paginate(12);
        return view('guest.sarana', compact('facilities'));
    }

    public function showFacility($id)
    {
        $facility = Facility::where('active', 1)->findOrFail($id);
        return view('guest.facility_detail', compact('facility'));
    }
}