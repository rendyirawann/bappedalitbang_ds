<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tetap menggunakan nama tabel asli dari Yii2 agar data lama mudah di-import
        Schema::create('unduhan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Kolom dari Yii2
            $table->string('namaFile')->nullable();

            // Relasi ke tabel bidang menggunakan UUID
            // Pastikan tabel bidang sudah dibuat lebih dulu dengan primary key UUID
            $table->foreignUuid('refbidang_id')->nullable()->constrained('bidang')->nullOnDelete();

            // Standar Laravel untuk pencatatan waktu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unduhan');
    }
};
