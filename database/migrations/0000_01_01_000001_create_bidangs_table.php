<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bidang', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Kolom nama bidang dari Yii2
            $table->string('bidang');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang');
    }
};
