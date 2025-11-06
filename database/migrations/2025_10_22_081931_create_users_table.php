<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // identitas pengguna
            $table->string('nama');
            $table->string('nim')->unique();

            // atribut organisasi
            $table->enum('role', ['Anggota', 'Bendahara', 'Ketua', 'Sekretaris', 'Super Admin'])->default('Anggota');
            $table->enum('departemen', [
                'Minat dan Bakat',
                'Humas',
                'Advokasi',
                'Pendidikan',
                'PRTK',
                'Kominfo',
                'Sosker'
            ]);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            // login system
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
