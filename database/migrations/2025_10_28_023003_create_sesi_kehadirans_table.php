<?php
// database/migrations/...._create_sesi_kehadirans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_kehadirans', function (Blueprint $table) {
            $table->id();
            // 'admin_id' merujuk ke 'id' dari tabel 'users'
            $table->foreignId('admin_id')->constrained('users'); // Admin (non-anggota) yang membuat
            $table->string('event_name');
            $table->string('token')->unique(); // Token unik untuk QR Code
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->integer('radius'); // Radius valid dalam meter
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_kehadirans');
    }
};