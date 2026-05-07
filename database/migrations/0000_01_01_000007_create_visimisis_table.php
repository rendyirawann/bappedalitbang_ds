<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visimisi', function (Blueprint $table) {
            // Menggunakan UUID sebagai primary key
            $table->uuid('id')->primary();

            // Kolom dari Yii2
            // Menggunakan tipe 'text' dan 'longText' karena biasanya Visi Misi berisi paragraf yang panjang
            $table->text('visiJudul')->nullable();
            $table->longText('visiTeks')->nullable();
            $table->text('misiJudul')->nullable();
            $table->longText('misiTeks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visimisi');
    }
};
