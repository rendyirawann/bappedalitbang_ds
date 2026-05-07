<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Lajur biasa dari Yii2
            $table->integer('statusAparatur');
            $table->string('namaLengkap', 100);
            $table->string('nip', 22)->nullable();
            $table->string('no_hp', 15)->nullable();

            // Kunci Asing menggunakan UUID
            $table->foreignUuid('eselon')->nullable()->constrained('pegawai_eselon')->nullOnDelete();
            $table->foreignUuid('kodeBidang')->nullable()->constrained('bidang')->nullOnDelete();
            $table->foreignUuid('kodeTitle')->nullable()->constrained('title')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
