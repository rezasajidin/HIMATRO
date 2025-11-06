<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan beberapa seeder sekaligus
        $this->call([
            AdminSeeder::class,
            TemplateSuratSeeder::class,
        ]);
    }
}
