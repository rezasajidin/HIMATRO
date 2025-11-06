<?php
// database/migrations/2025_10_28_023035_create_kehadirans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan ini membuat tabel 'kehadirans', BUKAN 'sesi_kehadirans'
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('sesi_kehadiran_id')->constrained('sesi_kehadirans');
            $table->decimal('user_latitude', 10, 7);
            $table->decimal('user_longitude', 10, 7);
            $table->enum('status', ['hadir', 'tidak_valid']);
            $table->timestamp('waktu_hadir');
            $table->timestamps();
            
            $table->unique(['user_id', 'sesi_kehadiran_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};