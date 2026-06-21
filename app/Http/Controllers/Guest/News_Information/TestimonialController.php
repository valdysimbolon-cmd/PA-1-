<?php

namespace App\Http\Controllers\Guest\News_Information;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function allTestimonials()
    {
        $testimonials = Testimonial::where('active', 1)->latest()->paginate(9);
        return view('guest.testimoni', compact('testimonials'));
    }

    public function showTestimonial($id)
    {
        $testi = Testimonial::findOrFail($id);
        return view('guest.testimoni_detail', compact('testi'));
    }
}