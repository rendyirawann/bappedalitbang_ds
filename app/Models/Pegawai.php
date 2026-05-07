<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pegawai extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai'; //

    protected $fillable = [
        'statusAparatur',
        'namaLengkap',
        'nip',
        'eselon',
        'kodeBidang',
        'kodeTitle',
        'no_hp',
    ];

    /**
     * Dalam Yii2, ini ditulis sebagai hasOne.
     * Dalam Laravel, kerana foreign key berada di dalam jadual pegawai, kita menggunakan belongsTo.
     */
    public function pegawaiEselon()
    {
        return $this->belongsTo(PegawaiEselon::class, 'eselon');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'kodeBidang');
    }

    public function title()
    {
        return $this->belongsTo(Title::class, 'kodeTitle');
    }
}
