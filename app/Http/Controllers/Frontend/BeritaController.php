<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Helper untuk mengambil data Sidebar (Berita Terbaru & Kategori Bidang)
     */
    private function getSidebarData()
    {
        // Mengambil 5 berita terbaru yang statusnya Publish (1)
        $latestBerita = Berita::where('status', 1)->latest('tgl_berita')->take(5)->get();

        // Mengambil daftar Bidang beserta JUMLAH berita yang aktif (status = 1) di dalamnya
        $kategoriBidang = Bidang::withCount(['beritas' => function ($query) {
            $query->where('status', 1);
        }])->get();

        return compact('latestBerita', 'kategoriBidang');
    }

    /**
     * Menampilkan semua Berita dengan Paginasi (5 per halaman)
     */
    public function index()
    {
        $beritas = Berita::with('bidang')
            ->where('status', 1)
            ->latest('tgl_berita')
            ->paginate(5); // Pengganti $dataProvider->pagination di Yii2

        $sidebar = $this->getSidebarData();

        return view('frontend.berita.index', compact('beritas') + $sidebar);
    }

    /**
     * Menampilkan Berita berdasarkan Kategori Bidang
     */
    public function indexBidang($bidang_id)
    {
        $bidangInfo = Bidang::findOrFail($bidang_id);

        $beritas = Berita::with('bidang')
            ->where('status', 1)
            ->where('bidang_id', $bidang_id)
            ->latest('tgl_berita')
            ->paginate(5);

        $sidebar = $this->getSidebarData();

        return view('frontend.berita.index', compact('beritas', 'bidangInfo') + $sidebar);
    }

    /**
     * Menampilkan Detail Berita dan Gambar Alternatifnya
     */
    public function show($id)
    {
        $berita = Berita::with(['bidang', 'beritaAlts'])->findOrFail($id);
        $sidebar = $this->getSidebarData();

        return view('frontend.berita.show', compact('berita') + $sidebar);
    }
}
