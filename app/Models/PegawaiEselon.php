<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PegawaiEselon extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_eselon'; //

    protected $fillable = [
        'nm_eselon',
    ];

    // Hubungan ke Pegawai
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'eselon');
    }
}
