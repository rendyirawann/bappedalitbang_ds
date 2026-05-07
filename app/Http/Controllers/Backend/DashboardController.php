<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Panggil Model yang dibutuhkan (Pastikan Model ini sudah ada, jika belum nanti kita buat)
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Bidang;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek Role Kabid: Di Yii2 Anda pakai $assignments['kabid'].
        // Di Laravel, sementara kita deteksi jika user punya bidang_id dan bukan superadmin.
        // Nanti jika Anda pakai Spatie Permission, bisa diganti jadi $user->hasRole('kabid')
        $isKabid = !is_null($user->bidang_id) && !in_array($user->username, ['developer', 'admin']);

        if ($isKabid) {
            $userBidangId = $user->bidang_id;

            // Hitung data khusus bidang user tersebut
            $countBeritaPerencanaan = Berita::where('bidang_id', $userBidangId)->count();
            $countBeritaReview = Berita::where('status', 0)->where('bidang_id', $userBidangId)->count();
            $countBeritaPublish = Berita::where('status', 1)->where('bidang_id', $userBidangId)->count();
        } else {
            // Hitung data keseluruhan (Untuk Developer / Admin)
            $countBeritaPerencanaan = Berita::count();
            $countBeritaReview = Berita::where('status', 0)->count();
            $countBeritaPublish = Berita::where('status', 1)->count();
        }

        // Mengambil jumlah semua galeri
        $countGaleri = Galeri::count();

        // ============================================
        // LOGIK DATA GRAFIK (BAR CHART)
        // ============================================
        $bidangData = Bidang::all();
        $bidangLabels = [];
        $bidangCounts = [];

        // Membuat array singkatan bidang (Sama persis seperti Yii2)
        $bidangSingkatan = [
            'PPEPD' => 'PPEPD',
            'Infrastruktur dan Kewilayahan' => 'IDK',
            'Penelitian dan Pengembangan' => 'Litbang',
            'Bagian Umum' => 'Umum',
            'Program' => 'Program',
            'Keuangan' => 'Keuangan',
            'Ekonomi dan SDA' => 'Ekonomi',
            'Pemerintahan dan Pembangunan Manusia' => 'PPM'
        ];

        foreach ($bidangData as $bidang) {
            $countBerita = Berita::where('bidang_id', $bidang->id)->count();

            if ($countBerita > 0) { // Hanya masukkan bidang yang memiliki berita
                // Jika namanya ada di array singkatan, pakai singkatan. Jika tidak, pakai nama aslinya
                $bidangLabels[] = $bidangSingkatan[$bidang->bidang] ?? $bidang->bidang;
                $bidangCounts[] = $countBerita;
            }
        }

        // Data dummy untuk Log Aktivitas agar tidak error di Blade (Bisa disambungkan ke tabel log nanti)
        $recentLogs = [];

        return view('backend.dashboard.index', compact(
            'countBeritaPerencanaan',
            'countBeritaReview',
            'countBeritaPublish',
            'countGaleri',
            'bidangLabels',
            'bidangCounts',
            'recentLogs'
        ));
    }
}
