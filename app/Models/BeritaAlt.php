<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BeritaAlt extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'berita_alt';

    protected $fillable = ['berita_id', 'file', 'keterangan'];

    // Relasi kembali ke tabel Berita
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }
}
