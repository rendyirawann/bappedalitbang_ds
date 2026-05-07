<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur', function (Blueprint $table) {
            // Menggunakan UUID sebagai primary key
            $table->uuid('id')->primary();

            // Kolom dari Yii2
            $table->string('namaFile')->nullable();
            $table->string('file')->nullable(); // Path/nama file gambar

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur');
    }
};
