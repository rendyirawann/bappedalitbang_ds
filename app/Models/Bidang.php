<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Bidang extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan dengan nama tabel di database
    protected $table = 'bidang';

    protected $fillable = [
        'bidang',
    ];

    /**
     * Relasi ke tabel Berita (One to Many)
     */
    public function beritas()
    {
        return $this->hasMany(Berita::class, 'bidang_id');
    }

    /**
     * Relasi ke tabel Unduhan (One to Many) 
     * Menggunakan versi Frontend (hasMany) karena lebih masuk akal 1 bidang punya banyak unduhan
     */
    public function unduhans()
    {
        return $this->hasMany(Unduhan::class, 'refbidang_id');
    }

    /**
     * Relasi ke tabel User (One to Many)
     * Satu bidang di Bappeda biasanya memiliki lebih dari 1 user/pegawai
     */
    public function users()
    {
        return $this->hasMany(User::class, 'bidang_id');
    }
}
