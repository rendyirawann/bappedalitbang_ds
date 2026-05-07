<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unduhan_file', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke tabel unduhan (UUID) dengan fitur cascade delete
            $table->foreignUuid('refunduhan_id')
                ->nullable()
                ->constrained('unduhan')
                ->cascadeOnDelete(); // Jika record unduhan dihapus, filenya ikut terhapus

            // Kolom dari Yii2
            $table->string('file')->nullable();
            $table->timestamp('tanggalUpload')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unduhan_file');
    }
};
