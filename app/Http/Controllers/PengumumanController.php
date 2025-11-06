<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('created_at', 'desc')->get();
        return view('dashboard.pengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'day_date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'closing' => 'required|string',
        ]);

        Pengumuman::create($request->only([
            'title',
            'short_description',
            'full_description',
            'day_date',
            'time',
            'location',
            'closing',
        ]));

        return redirect()->back()->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return response()->json($pengumuman);
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'day_date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'closing' => 'required|string',
        ]);

        $pengumuman->update($request->only([
            'title',
            'short_description',
            'full_description',
            'day_date',
            'time',
            'location',
            'closing',
        ]));

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}