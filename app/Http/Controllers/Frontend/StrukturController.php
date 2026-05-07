<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Struktur;
use Illuminate\Http\Request;

class StrukturController extends Controller
{
    /**
     * Menampilkan halaman Struktur Organisasi
     * Pengganti actionIndex() di Yii2
     */
    public function index()
    {
        // Mengambil semua data struktur (biasanya hanya 1 sesuai aturan backend)
        $strukturs = Struktur::all();

        // Di Yii2 Anda membuat array titles. Di Laravel, kita bisa menggunakan Collection method pluck().
        $titles = $strukturs->pluck('namaFile')->implode(', ');

        return view('frontend.struktur.index', compact('strukturs', 'titles'));
    }
}
