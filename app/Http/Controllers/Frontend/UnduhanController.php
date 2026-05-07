<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use App\Models\UnduhanFile;
use Illuminate\Http\Request;

class UnduhanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mengambil profil (diurutkan dari yang terbaru)
        $profils = Profil::orderBy('tanggalUpload', 'desc')->get();

        // 2. Query Optimal menggunakan Join agar bisa di-Order berdasarkan Bidang
        $query = UnduhanFile::select('unduhan_file.*')
            ->join('unduhan', 'unduhan_file.refunduhan_id', '=', 'unduhan.id')
            ->leftJoin('bidang', 'unduhan.refbidang_id', '=', 'bidang.id')
            ->with(['unduhan.bidang']);

        // 3. Fitur Pencarian (Live Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('unduhan_file.file', 'like', '%' . $search . '%')
                ->orWhere('unduhan.namaFile', 'like', '%' . $search . '%')
                ->orWhere('bidang.bidang', 'like', '%' . $search . '%');
        }

        // 4. Pengurutan spesifik: Bidang -> Kategori (namaFile) -> Tanggal
        // Di-limit 15 per halaman agar pengelompokan terlihat rapi
        $unduhanFiles = $query->orderBy('bidang.bidang', 'asc')
            ->orderBy('unduhan.namaFile', 'asc')
            ->orderBy('unduhan_file.tanggalUpload', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('frontend.unduhan.index', compact('profils', 'unduhanFiles'));
    }
}
