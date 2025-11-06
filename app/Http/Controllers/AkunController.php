<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::all();

        $totalAkun = $users->count();
        $akunAktif = $users->where('status', 'Active')->count();
        $akunInactive = $users->where('status', 'Inactive')->count();

        return view('dashboard.kelolaakun', compact('users', 'totalAkun', 'akunAktif', 'akunInactive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim',
            'role' => 'required|in:Anggota,Bendahara,Ketua,Sekretaris,pic departemen',
            'departemen' => 'required|in:Minat dan Bakat,Humas,Advokasi,Pendidikan,PRTK,Kominfo,Sosker',
            'status' => 'required|in:Active,Inactive',
        ]);

        User::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'role' => $request->role,
            'departemen' => $request->departemen,
            'status' => $request->status,
            'email' => $request->nim . '@himatro.com', // auto generate email
            'password' => bcrypt('password123'),       // password default
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
