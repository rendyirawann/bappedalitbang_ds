<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai_eselon', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Lajur dari Yii2
            $table->string('nm_eselon');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai_eselon');
    }
};
