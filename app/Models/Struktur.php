<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Exception;

class Struktur extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan dengan nama tabel di database
    protected $table = 'struktur';

    // Kolom yang diizinkan untuk diisi secara mass-assignment
    protected $fillable = [
        'namaFile',
        'file',
    ];

    /**
     * PROTEKSI 1 ROW SAJA
     * Pengganti fungsi beforeSave() dari Yii2
     */
    protected static function boot()
    {
        parent::boot();

        // Event ini akan dipicu tepat KETIKA data baru akan disimpan (Create)
        static::creating(function ($model) {
            // Jika sudah ada data di database
            if (self::count() > 0) {
                // Gagalkan proses penyimpanan dengan melempar Exception
                // Pesan error disamakan dengan flash message di Yii2
                throw new Exception('Hanya diperbolehkan satu data Struktur. Silahkan edit data yang ada.');
            }
        });
    }
}
