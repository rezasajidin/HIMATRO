<?php

namespace App\Http\Controllers;

use App\Models\TemplateSurat;
use App\Models\Surat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TemplateSuratController extends Controller
{
    /**
     * Menampilkan daftar template surat.
     */
    public function index()
    {
        $templates = TemplateSurat::all();
        return view('surat.template', compact('templates'));
    }

    /**
     * Menampilkan form pembuatan surat berdasarkan template terpilih.
     */
    public function create($id)
    {
        $template = TemplateSurat::findOrFail($id);
        return view('surat.generate', compact('template'));
    }

    /**
     * Generate surat menjadi file PDF setelah mengisi form.
     */
    public function generate(Request $request, $id)
    {
        $template = TemplateSurat::findOrFail($id);

        // Ambil isi template dan ganti placeholder dengan data form
        $isi = $template->isi;
        foreach ($request->except('_token') as $key => $value) {
            $isi = str_replace('{{' . $key . '}}', e($value), $isi);
        }

        // Buat PDF dari tampilan preview
        $pdf = Pdf::loadView('surat.preview', [
            'isi' => $isi,
            'template' => $template,
            'data' => $request->all(),
        ])->setPaper('A4', 'portrait');

        // Unduh file PDF dengan nama sesuai tipe surat
        return $pdf->download('Surat_' . str_replace(' ', '_', $template->tipe) . '_' . time() . '.pdf');
    }

    /**
     * Generate PDF dari surat yang sudah tersimpan di database.
     */
    public function generatePDF($id)
    {
        $surat = Surat::findOrFail($id);

        $pdf = Pdf::loadView('surat.pdf', compact('surat'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('Surat_' . $surat->jenis . '.pdf');
    }
}
