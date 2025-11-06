<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Tampilkan daftar kegiatan.
     */
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('date', 'desc')->get();
        return view('dashboard.kegiatan', compact('kegiatan'));
    }

    /**
     * Simpan kegiatan baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'status' => 'required|string|in:Akan Datang,Berjalan,Selesai',
        ]);

        Kegiatan::create($data);

        return redirect()->back()->with('success', 'Kegiatan berhasil dibuat.');
    }

    /**
     * Perbarui kegiatan.
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'status' => 'required|string|in:Akan Datang,Berjalan,Selesai',
        ]);

        $kegiatan->update($data);

        return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus kegiatan.
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus.');
    }
}