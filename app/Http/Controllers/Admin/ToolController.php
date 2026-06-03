<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller {
    public function index() {
        $tools = Tool::with('lab')->latest()->get();
        return view('admin.tool.index', compact('tools'));
    }

    public function create() {
        $labs = Lab::where('active', 1)->get();
        return view('admin.tool.create', compact('labs'));
    }

    public function store(Request $request) {
        $request->validate(['lab_id' => 'required', 'code' => 'required|unique:tools', 'name' => 'required', 'stock_total' => 'required|numeric']);
        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['is_borrowable'] = $request->has('is_borrowable'); // Checkbox logic

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tools', 'public');
        }
        Tool::create($data);
        return redirect()->route('tools.index')->with('success', 'Alat masuk katalog');
    }

    public function edit(Tool $tool) {
        $labs = Lab::where('active', 1)->get();
        return view('admin.tool.edit', compact('tool', 'labs'));
    }

    public function update(Request $request, Tool $tool) {
        $data = $request->all();
        $data['active'] = $request->boolean('active');
        if ($request->hasFile('image')) {
            if ($tool->image) Storage::disk('public')->delete($tool->image);
            $data['image'] = $request->file('image')->store('tools', 'public');
        }
        $tool->update($data);
        return redirect()->route('tools.index')->with('success', 'Data alat diperbarui!');
    }

    public function destroy(Tool $tool) {
        if ($tool->image) Storage::disk('public')->delete($tool->image);
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Alat dihapus!');
    }
}