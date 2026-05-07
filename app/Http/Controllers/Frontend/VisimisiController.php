<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Visimisi;
use Illuminate\Http\Request;

class VisimisiController extends Controller
{
    /**
     * Menampilkan halaman Visi Misi
     * Pengganti actionIndex() di Yii2
     */
    public function index()
    {
        // Visimisi::find()->one() di Yii2 menjadi Visimisi::first() di Laravel
        $visimisiData = Visimisi::first();

        return view('frontend.visimisi.index', compact('visimisiData'));
    }
}
