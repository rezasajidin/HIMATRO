<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Super Admin',
            'nim' => '00000001',
            'role' => 'Sekretaris',
            'departemen' => 'Kominfo',
            'status' => 'Active',
            'email' => 'admin@himatro.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
