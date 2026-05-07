<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\BeritaAlt; // Untuk gambar tambahan nanti
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Jika Superadmin/Admin/Operator, tampilkan semua. Jika tidak, sesuaikan bidang.
        if (in_array($user->username, ['developer', 'admin', 'operator'])) {
            $beritas = Berita::orderBy('id', 'desc')->get();
        } else {
            $beritas = Berita::where('bidang_id', $user->bidang_id)->orderBy('id', 'desc')->get();
        }

        return view('backend.berita.index', compact('beritas'));
    }

    public function create()
    {
        // Lempar data Bidang untuk dropdown
        $bidangs = Bidang::all();
        return view('backend.berita.create', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judulBerita' => 'required',
            'isiBerita'   => 'required',
            'tgl_berita'  => 'required|date',
            'status'      => 'required|integer',
            'file_doc'    => 'required|image|mimes:jpeg,png,jpg|max:10240' // Maks 10MB
        ]);

        $model = new Berita();
        $model->judulBerita = $request->judulBerita;
        $model->isiBerita   = $request->isiBerita;
        $model->tgl_berita  = $request->tgl_berita;
        $model->keterangan  = $request->keterangan;
        $model->status      = $request->status;

        // Penentuan Bidang ID
        $user = Auth::user();
        if (in_array($user->username, ['developer', 'admin', 'operator'])) {
            $model->bidang_id = $request->bidang_id; // Dari dropdown form
        } else {
            $model->bidang_id = $user->bidang_id; // Otomatis sesuai user
        }

        if ($request->hasFile('file_doc')) {
            $file = $request->file('file_doc');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/berita'), $filename);
            $model->file = $filename;
        }

        $model->save();

        return redirect('admin/berita')->with('success', 'Berita Perencanaan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $model = Berita::findOrFail($id);

        // Cek Hak Akses Data
        $user = Auth::user();
        if (!in_array($user->username, ['developer', 'admin', 'operator']) && $model->bidang_id != $user->bidang_id) {
            abort(403, 'Anda tidak memiliki akses ke berita ini.');
        }

        return view('backend.berita.show', compact('model'));
    }

    public function edit($id)
    {
        $model = Berita::findOrFail($id);

        $user = Auth::user();
        if (!in_array($user->username, ['developer', 'admin', 'operator']) && $model->bidang_id != $user->bidang_id) {
            abort(403, 'Anda tidak memiliki akses ke berita ini.');
        }

        $bidangs = Bidang::all();
        return view('backend.berita.edit', compact('model', 'bidangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judulBerita' => 'required',
            'isiBerita'   => 'required',
            'tgl_berita'  => 'required|date',
            'status'      => 'required|integer',
            'file_doc'    => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $model = Berita::findOrFail($id);
        $model->judulBerita = $request->judulBerita;
        $model->isiBerita   = $request->isiBerita;
        $model->tgl_berita  = $request->tgl_berita;
        $model->keterangan  = $request->keterangan;
        $model->status      = $request->status;

        $user = Auth::user();
        if (in_array($user->username, ['developer', 'admin', 'operator']) && $request->has('bidang_id')) {
            $model->bidang_id = $request->bidang_id;
        }

        if ($request->hasFile('file_doc')) {
            if (File::exists(public_path('storage/uploads/berita/' . $model->file))) {
                File::delete(public_path('storage/uploads/berita/' . $model->file));
            }

            $file = $request->file('file_doc');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/berita'), $filename);
            $model->file = $filename;
        }

        $model->save();

        return redirect('admin/berita')->with('success', 'Berita Perencanaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $model = Berita::findOrFail($id);

        $user = Auth::user();
        if (!in_array($user->username, ['developer', 'admin', 'operator']) && $model->bidang_id != $user->bidang_id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus berita ini.');
        }

        if (File::exists(public_path('storage/uploads/berita/' . $model->file))) {
            File::delete(public_path('storage/uploads/berita/' . $model->file));
        }

        $model->delete();

        return redirect('admin/berita')->with('success', 'Berita berhasil dihapus.');
    }

    public function preview($id)
    {
        // Ubah nama variabel dari $model menjadi $berita agar cocok dengan frontend
        $berita = Berita::findOrFail($id);

        // Data Sidebar (Ganti nama variabel agar persis dengan desain frontend Anda)
        $latestBeritas = Berita::where('status', 1)->orderBy('tgl_berita', 'desc')->limit(5)->get();

        // Menggunakan withCount agar $bidang->beritas_count bisa terbaca di Blade
        $kategoriBidang = Bidang::withCount('beritas')->get();

        return view('backend.berita.preview', compact('berita', 'latestBeritas', 'kategoriBidang'));
    }

    public function download($id)
    {
        $model = Berita::findOrFail($id);
        $filePath = public_path('storage/uploads/berita/' . $model->file);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'File gambar tidak ditemukan.');
    }
}
