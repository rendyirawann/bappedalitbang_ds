<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Title extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'title'; //

    protected $fillable = [
        'title',
    ];

    // Hubungan ke Pegawai (Satu Title boleh dimiliki oleh ramai Pegawai)
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'kodeTitle');
    }
}
