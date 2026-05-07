<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            // Menggunakan UUID sebagai primary key
            $table->uuid('id')->primary();

            // Kolom dari Yii2
            $table->string('namaFile')->nullable(); // Di backend Yii2 Anda memberi label ini sebagai 'Nama Kegiatan'
            $table->string('file')->nullable(); // Path/nama file gambar yang tersimpan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
