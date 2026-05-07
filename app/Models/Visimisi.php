<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Exception;

class Visimisi extends Model
{
    use HasFactory, HasUuids;

    // Menyesuaikan dengan nama tabel di database
    protected $table = 'visimisi';

    // Kolom yang diizinkan untuk diisi secara mass-assignment
    protected $fillable = [
        'visiJudul',
        'visiTeks',
        'misiJudul',
        'misiTeks',
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
            // Jika mencoba membuat data baru padahal data sudah ada
            if (self::count() > 0) {
                // Gagalkan proses penyimpanan dengan melempar Exception
                // Pesan error disamakan dengan flash message di Yii2
                throw new Exception('Data Visi Misi sudah ada. Hanya boleh satu baris data.');
            }
        });
    }
}
