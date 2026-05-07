<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Unduhan extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan nama tabel dengan bawaan Yii2
    protected $table = 'unduhan';

    protected $fillable = [
        'namaFile',
        'refbidang_id',
    ];

    // Relasi ke tabel Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'refbidang_id');
    }

    // Relasi ke tabel UnduhanFile (Has Many)
    public function unduhanFiles()
    {
        return $this->hasMany(UnduhanFile::class, 'refunduhan_id');
    }
}
