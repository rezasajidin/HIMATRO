<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel surat.
     */
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // nama file surat
            $table->enum('kategori', ['Masuk', 'Keluar']); // kategori surat
            $table->string('path'); // lokasi file disimpan di storage
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel surat).
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
