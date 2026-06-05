<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function index() {
        $labs = Lab::with('head')->latest()->get();
        return view('admin.lab.index', compact('labs'));
    }

    public function create() {
        $lecturers = Lecturer::all();
        $staffs = User::all(); // Untuk pilihan Staf PIC
        return view('admin.lab.create', compact('lecturers', 'staffs'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['staff_id'] = auth()->id();
        $data['slug'] = Str::slug($request->name);
        $data['created_by'] = auth()->id();
        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('labs', 'public');
        }

        Lab::create($data);
        return redirect()->route('labs.index')->with('success', 'Unit Lab Berhasil Dibuat');
    }

    public function edit(Lab $lab) {
        $lecturers = Lecturer::all();
        $staffs = User::all();
        return view('admin.lab.edit', compact('lab', 'lecturers', 'staffs'));
    }

    public function update(Request $request, Lab $lab) {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['updated_by'] = auth()->id();
        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($lab->image) Storage::disk('public')->delete($lab->image);
            $data['image'] = $request->file('image')->store('labs', 'public');
        }

        $lab->update($data);
        return redirect()->route('labs.index')->with('success', 'Unit Lab Berhasil Diperbarui');
    }
}