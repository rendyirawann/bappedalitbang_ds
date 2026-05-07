<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Berita extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'berita';

    protected $fillable = [
        'file',
        'judulBerita',
        'isiBerita',
        'bidang_id',
        'tgl_berita',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tgl_berita' => 'date',
    ];

    // Relasi ke tabel Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Relasi ke tabel BeritaAlt (Has Many)
    public function beritaAlts()
    {
        return $this->hasMany(BeritaAlt::class, 'berita_id');
    }

    // Fungsi Accessor/Helper dari Yii2 Backend untuk menerjemahkan status
    public function getStatusText()
    {
        $statusText = [
            0 => 'Review',
            1 => 'Publish',
            2 => 'Ditolak',
        ];

        return $statusText[$this->status] ?? 'Unknown';
    }
}
