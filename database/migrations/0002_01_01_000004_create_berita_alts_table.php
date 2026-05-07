<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_alt', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke tabel berita
            $table->foreignUuid('berita_id')
                ->nullable()
                ->constrained('berita')
                ->cascadeOnDelete(); // Hapus otomatis jika berita dihapus

            $table->string('file')->nullable(); // Gambar tambahan/galeri

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_alt');
    }
};
