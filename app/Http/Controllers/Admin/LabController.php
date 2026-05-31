<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LabController extends Controller {
    public function index() {
        $labs = Lab::with(['staff', 'head'])->latest()->get();
        return view('admin.lab.index', compact('labs'));
    }

    public function create() {
        $lecturers = Lecturer::where('active', 1)->get();
        $staffs = User::where('role', 'admin_lab')->get();
        return view('admin.lab.create', compact('lecturers', 'staffs'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'staff_id' => 'required', 'category' => 'required', 'image' => 'nullable|image|max:2048']);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['active'] = $request->boolean('active');
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('labs', 'public'); }
        Lab::create($data);
        return redirect()->route('labs.index')->with('success', 'Unit Lab berhasil dibuat!');
    }

    public function edit(Lab $lab) {
        $lecturers = Lecturer::where('active', 1)->get();
        $staffs = User::where('role', 'admin_lab')->get();
        return view('admin.lab.edit', compact('lab', 'lecturers', 'staffs'));
    }

    public function update(Request $request, Lab $lab) {
        $data = $request->all();
        $data['active'] = $request->boolean('active');
        if ($request->hasFile('image')) {
            if ($lab->image) Storage::disk('public')->delete($lab->image);
            $data['image'] = $request->file('image')->store('labs', 'public');
        }
        $lab->update($data);
        return redirect()->route('labs.index')->with('success', 'Data Lab diperbarui!');
    }

    public function destroy(Lab $lab) {
        if ($lab->image) Storage::disk('public')->delete($lab->image);
        $lab->delete();
        return redirect()->route('labs.index')->with('success', 'Lab dihapus!');
    }
}