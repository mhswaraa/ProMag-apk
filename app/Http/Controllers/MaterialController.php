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

    // UPDATE SUB-POIN (Child) - Lebih Fleksibel
    public function updateStep(Request $request, $id)
    {
        $step = MaterialStep::findOrFail($id);
        
        // Kita gunakan array filter agar hanya mengupdate field yang dikirim saja
        // Ini memungkinkan kita edit Title saja, atau Status saja tanpa menimpa yang lain
        $data = array_filter($request->only(['title', 'status', 'user_notes', 'obstacles']));

        if ($request->has('status') && $request->status == 'completed') {
            $data['completed_at'] = now();
        }

        $step->update($data);

        return back()->with('success', 'Update berhasil!');
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

    public function destroy(Material $material)
    {
        // Pastikan hanya pemilik yang bisa menghapus
        if ($material->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus semua steps terkait terlebih dahulu (Opsional jika sudah set on cascade delete di migration)
        $material->steps()->delete();
        
        // Hapus materi
        $material->delete();

        return back()->with('success', 'Topik materi berhasil dihapus.');
    }

    // TAMBAHKAN: Hapus Sub-Poin (Step)
    public function destroyStep($id)
    {
        $step = MaterialStep::findOrFail($id);
        
        // Validasi kepemilikan (via relation materi)
        if ($step->material->user_id !== Auth::id()) {
            abort(403);
        }

        $step->delete();

        return back()->with('success', 'Langkah pembelajaran dihapus.');
    }
    // UPDATE TOPIK UTAMA (Parent)
    public function update(Request $request, $id)
    {
        $material = Material::where('user_id', Auth::id())->findOrFail($id);

        $material->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Informasi topik berhasil diperbarui!');
    }

    
}
