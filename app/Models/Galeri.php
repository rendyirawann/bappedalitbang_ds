<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Galeri extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan dengan nama tabel di database
    protected $table = 'galeri';

    // Kolom yang diizinkan untuk diisi secara mass-assignment
    protected $fillable = [
        'namaFile',
        'file',
    ];
}
