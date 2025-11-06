<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::orderBy('tanggal', 'desc')->get();
        $totalMasuk = Transaksi::where('tipe', 'Masuk')->sum('jumlah');
        $totalKeluar = Transaksi::where('tipe', 'Keluar')->sum('jumlah');
        $totalSaldo = $totalMasuk - $totalKeluar;

        return view('dashboard.keuangan', compact('transaksis', 'totalMasuk', 'totalKeluar', 'totalSaldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tipe' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|numeric|min:0',
            
        ]);

        Transaksi::create($request->all());
        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
