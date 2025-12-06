<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        // Ambil materi beserta steps-nya
        $materials = Material::where('user_id', $userId)
                        ->with('steps')
                        ->latest()
                        ->get();

        return view('materials.index', compact('materials'));
    }

    // Function untuk Update Progress Poin
    public function updateStep(Request $request, $id)
    {
        $step = MaterialStep::findOrFail($id);
        
        $step->update([
            'status' => $request->status,
            'user_notes' => $request->user_notes,
            'completed_at' => $request->status == 'completed' ? now() : null,
        ]);

        return back()->with('success', 'Progress berhasil diperbarui!');
    }

    // Function Tambah Materi Baru
    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);

        $material = Material::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category ?? 'Hard Skill',
            'description' => $request->description,
        ]);

        // Jika ada sub-poin awal, bisa ditambahkan disini logic-nya
        // Untuk simpelnya, kita buat materi dulu, baru tambah step di UI

        return back()->with('success', 'Topik materi baru ditambahkan!');
    }

    // Function Tambah Sub-Poin (Step)
    public function storeStep(Request $request)
    {
        MaterialStep::create([
            'material_id' => $request->material_id,
            'title' => $request->title,
            'status' => 'todo'
        ]);

        return back();
    }
}
