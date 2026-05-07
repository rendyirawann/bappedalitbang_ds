<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Menampilkan halaman Galeri Kegiatan
     * Pengganti actionIndex() di Yii2
     */
    public function index()
    {
        // Menggunakan paginate(9) agar MySQL membatasi data (Optimal Query).
        // Angka 9 dipilih agar grid 3-kolom kita selalu penuh dan rapi.
        $galeris = Galeri::latest()->paginate(9);

        return view('frontend.galeri.index', compact('galeris'));
    }
}
