<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Ubah dari "class CreateBansTable extends Migration" menjadi format modern di bawah ini:
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->increments('id');

            // Kita tetap menggunakan uuidMorphs yang sudah kita sesuaikan sebelumnya
            $table->uuidMorphs('bannable');
            $table->nullableUuidMorphs('created_by');

            $table->text('comment')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('expired_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bans');
    }
};
