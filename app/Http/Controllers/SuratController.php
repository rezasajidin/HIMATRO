<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\TemplateSurat;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    // =========================
    // MENAMPILKAN DAFTAR SURAT
    // =========================
    public function index()
    {
        $surat = Surat::latest()->get();
        return view('dashboard.surat', compact('surat'));
    }

    // =========================
    // MENYIMPAN FILE SURAT BIASA (UPLOAD)
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'kategori' => 'required|in:Masuk,Keluar',
            'file' => 'required|mimes:pdf,docx,png,jpg|max:2048',
        ]);

        // Simpan file ke storage
        $path = $request->file('file')->store('surat', 'public');

        Surat::create([
            'filename' => $request->filename,
            'kategori' => $request->kategori,
            'path' => $path,
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diupload!');
    }

    // =========================
    // HAPUS SURAT
    // =========================
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);

        // Hapus file dari storage
        Storage::disk('public')->delete($surat->path);

        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus!');
    }

    // =========================
    // MENAMPILKAN DAFTAR TEMPLATE SURAT
    // =========================
    public function template()
    {
        $templates = TemplateSurat::all();
        return view('surat.template', compact('templates'));
    }

    // =========================
    // FORM UNTUK MENGISI DATA TEMPLATE SURAT
    // =========================
    public function create($id)
    {
        $template = TemplateSurat::findOrFail($id);
        return view('surat.generate', compact('template'));
    }

    // =========================
    // GENERATE PDF DARI TEMPLATE SURAT
    // =========================
    public function generate(Request $request, $id)
    {
        $template = TemplateSurat::findOrFail($id);

        $validated = $request->validate([
            'kepada' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'detail' => 'nullable|string',
        ]);

        // Ganti placeholder di isi template
        $isiSurat = str_replace(
            ['{{kepada}}', '{{penanggung_jawab}}', '{{tanggal}}', '{{lokasi}}', '{{detail}}'],
            [$validated['kepada'], $validated['penanggung_jawab'], $validated['tanggal'], $validated['lokasi'], $validated['detail'] ?? ''],
            $template->isi
        );

        // Generate PDF dari view pdf.blade.php
        $pdf = Pdf::loadView('surat.pdf', [
            'surat' => (object)[
                'jenis' => $template->tipe,
                'kepada' => $validated['kepada'],
                'isi' => $isiSurat,
                'penanggung_jawab' => $validated['penanggung_jawab'],
                'tanggal' => $validated['tanggal'],
            ]
        ])->setPaper('A4', 'portrait');

        // Tampilkan langsung di browser
        return $pdf->stream('Surat_' . strtolower(str_replace(' ', '_', $template->tipe)) . '.pdf');
    }
}
