<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Profil extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan dengan nama tabel di database
    protected $table = 'profil';

    // Kolom yang diizinkan untuk diisi secara mass-assignment
    protected $fillable = [
        'namaFile',
        'file',
        'tanggalUpload',
    ];

    // Mengubah format tanggalUpload menjadi instance Carbon agar mudah dimanipulasi
    protected $casts = [
        'tanggalUpload' => 'datetime',
    ];
}
