<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SesiKehadiran;
use App\Models\Kehadiran;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    /**
     * Menampilkan halaman kehadiran berdasarkan role.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Role 'Anggota' adalah "User" (scanner)
        if ($user->role == 'Anggota') {
            return view('dashboard.kehadiran');
        
        // Role selain 'Anggota' adalah "Admin" (generator QR)
        } else {
            $latestSesi = SesiKehadiran::latest()->first();
            $kehadiranList = [];
            $sesiInfo = null;

            if ($latestSesi) {
                $sesiInfo = [
                    'event' => $latestSesi->event_name,
                    'tanggal' => $latestSesi->created_at->format('d/m/Y')
                ];
                
                $kehadiranList = Kehadiran::with('user')
                    ->where('sesi_kehadiran_id', $latestSesi->id)
                    ->get()
                    ->map(function ($item) {
                        // Gunakan nama kolom dari model User Anda: 'nama', 'nim', 'departemen'
                        return [
                            'id' => $item->id,
                            'nama' => $item->user->nama, // Sesuai model User Anda
                            'nim' => $item->user->nim,    // Sesuai model User Anda
                            'departemen' => $item->user->departemen ?? 'N/A', // Sesuai model User Anda
                            'waktu' => $item->waktu_hadir ? Carbon::parse($item->waktu_hadir)->format('H.i \W\I\B') : '-',
                            'status' => $item->status == 'hadir' ? 'Hadir' : 'Tidak Valid'
                        ];
                    });
            }

            return view('dashboard.kehadiran', [
                'kehadiranData' => $kehadiranList,
                'sesiInfo' => $sesiInfo
            ]);
        }
    }

    /**
     * Admin (non-Anggota): Membuat sesi QR Code baru.
     */
    public function generateQR(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'radius' => 'required|integer|min:1',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $token = Str::random(40);

        $sesi = SesiKehadiran::create([
            'admin_id' => Auth::id(),
            'event_name' => $request->event_name,
            'token' => $token,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return response()->json([
            'success' => true,
            'qrData' => $token, // Kirim token sebagai data QR
            'message' => 'Sesi QR berhasil dibuat.'
        ]);
    }

    /**
     * User (Anggota): Menyimpan data scan kehadiran.
     */
    public function storeScan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string', // Ini adalah token
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $token = $request->qr_data;
        $user = Auth::user();

        // 1. Cari sesi berdasarkan token
        $sesi = SesiKehadiran::where('token', $token)->first();

        if (!$sesi) {
            return redirect()->route('kehadiran.index')->with('error', 'QR Code tidak valid atau sesi tidak ditemukan.');
        }

        // 2. Cek apakah user sudah absen di sesi ini
        $existingKehadiran = Kehadiran::where('user_id', $user->id)
                                      ->where('sesi_kehadiran_id', $sesi->id)
                                      ->exists();

        if ($existingKehadiran) {
            return redirect()->route('kehadiran.index')->with('warning', 'Anda sudah mencatat kehadiran untuk sesi ini.');
        }

        // 3. Validasi Geolocation
        $distance = $this->haversineDistance(
            $sesi->latitude, $sesi->longitude,
            $request->latitude, $request->longitude
        );

        $status = ($distance <= $sesi->radius) ? 'hadir' : 'tidak_valid';
        $message = '';

        if ($status == 'hadir') {
            $message = 'Kehadiran berhasil dicatat!';
        } else {
            $message = 'Gagal: Anda berada (' . round($distance) . 'm) di luar radius yang diizinkan (' . $sesi->radius . 'm).';
        }

        // 4. Simpan data kehadiran
        Kehadiran::create([
            'user_id' => $user->id,
            'sesi_kehadiran_id' => $sesi->id,
            'user_latitude' => $request->latitude,
            'user_longitude' => $request->longitude,
            'status' => $status,
            'waktu_hadir' => Carbon::now(),
        ]);

        return redirect()->route('kehadiran.index')->with($status == 'hadir' ? 'success' : 'error', $message);
    }

    /**
     * Menghitung jarak antara dua titik koordinat (Haversine Formula).
     * Mengembalikan jarak dalam METER.
     */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // Jarak dalam meter
    }
}