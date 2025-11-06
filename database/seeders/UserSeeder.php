<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Ketua
        DB::table('users')->insert([
            'nim' => 'KETUA001',
            'name' => 'Ketua Himpunan',
            'email' => null,
            'password' => Hash::make('password123'),
            'role' => 'ketua',
            'member_number' => null,
            'department' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Sekretaris
        DB::table('users')->insert([
            'nim' => 'SEKRET001',
            'name' => 'Sekretaris Himpunan',
            'email' => null,
            'password' => Hash::make('password123'),
            'role' => 'sekeretaris',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Bendahara
        DB::table('users')->insert([
            'nim' => 'BEND001',
            'name' => 'Bendahara Himpunan',
            'email' => null,
            'password' => Hash::make('password123'),
            'role' => 'bendahara',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Beberapa PIC departemen (contoh)
        $pics = [
            ['nim' => 'PICPEND001','name'=>'PIC Pendidikan','department'=>'Pendidikan'],
            ['nim' => 'PICMIN001','name'=>'PIC Minat & Bakat','department'=>'Minat dan Bakat'],
            ['nim' => 'PICSOS001','name'=>'PIC Sosial & Kerohanian','department'=>'Sosial dan Kerohanian'],
            ['nim' => 'PICKOM001','name'=>'PIC Kominfo','department'=>'Kominfo'],
            ['nim' => 'PICPRT001','name'=>'PIC PRTK','department'=>'PRTK'],
        ];

        foreach ($pics as $p) {
            DB::table('users')->insert([
                'nim' => $p['nim'],
                'name' => $p['name'],
                'password' => Hash::make('password123'),
                'role' => 'pic departemen',
                'department' => $p['department'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 60 anggota (anggota 1..60). Ubah prefix NIM sesuai kebutuhan
        for ($i = 1; $i <= 60; $i++) {
            $nim = 'ANGG' . str_pad($i, 3, '0', STR_PAD_LEFT); // ANGG001, ANGG002, ...
            DB::table('users')->insert([
                'nim' => $nim,
                'name' => "Anggota $i",
                'password' => Hash::make('password123'),
                'role' => 'anggota',
                'member_number' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}