<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UnduhanFile extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan nama tabel dengan bawaan Yii2
    protected $table = 'unduhan_file';

    protected $fillable = [
        'refunduhan_id',
        'file',
        'tanggalUpload',
    ];

    // Otomatis mengubah format tanggalUpload menjadi instance Carbon/Datetime
    protected $casts = [
        'tanggalUpload' => 'datetime',
    ];

    // Relasi ke tabel Unduhan
    public function unduhan()
    {
        return $this->belongsTo(Unduhan::class, 'refunduhan_id');
    }
}
