<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Visimisi;

class SiteController extends Controller
{
    /**
     * Menampilkan halaman utama (Beranda)
     * Pengganti actionIndex() di Yii2
     */
    public function index()
    {
        // Visimisi::find()->one() di Yii2 menjadi first() di Laravel
        $visiMisi = Visimisi::first();

        // Visimisi::find()->all() di Yii2 menjadi all() atau get() di Laravel
        $visiDatas = Visimisi::all();

        // Berita::find()->where(...)->orderBy(...)->limit(4)->all()
        $latestBerita = Berita::where('status', 1)
            ->orderBy('tgl_berita', 'desc')
            ->take(4) // limit di Laravel
            ->get();

        $orderBerita = Berita::where('status', 1)
            ->orderBy('tgl_berita', 'desc')
            ->get();

        // Me-render view resources/views/frontend/site/index.blade.php
        return view('frontend.site.index', compact(
            'visiMisi',
            'visiDatas',
            'latestBerita',
            'orderBerita'
        ));
    }
}
