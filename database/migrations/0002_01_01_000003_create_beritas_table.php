<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Kolom dari Yii2
            $table->string('file')->nullable(); // Gambar sampul/utama
            $table->text('judulBerita');
            $table->longText('isiBerita');
            $table->date('tgl_berita')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status')->nullable()->default(0); // 0: Review, 1: Publish, 2: Ditolak

            // Relasi ke tabel bidang
            $table->foreignUuid('bidang_id')
                ->nullable()
                ->constrained('bidang')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
