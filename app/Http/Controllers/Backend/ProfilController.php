<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Profil; // Pastikan Model Profil sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfilController extends Controller
{
    private function checkAccess()
    {
        $user = Auth::user();
        // Di Yii2 Anda, operator juga diizinkan mengakses Berkas Profil
        if (!in_array($user->username, ['developer', 'admin', 'operator'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        // Optimasi: Hanya ambil kolom yang diperlukan
        $profils = Profil::select('id', 'namaFile', 'file', 'tanggalUpload', 'created_at')
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.profil.index', compact('profils'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
            // Mendukung dokumen dan gambar, maks 10MB
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpeg,png,jpg|max:10240'
        ]);

        $model = new Profil();
        $model->namaFile = $request->namaFile;
        // Set tanggal upload ke waktu saat ini
        $model->tanggalUpload = Carbon::now();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/profil'), $filename);
            $model->file = $filename;
        }

        $model->save();

        return redirect('admin/profil')->with('success', 'Berkas Profil berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpeg,png,jpg|max:10240'
        ]);

        $model = Profil::findOrFail($id);
        $model->namaFile = $request->namaFile;

        if ($request->hasFile('file')) {
            // Hapus file fisik yang lama
            if (File::exists(public_path('storage/uploads/profil/' . $model->file))) {
                File::delete(public_path('storage/uploads/profil/' . $model->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/profil'), $filename);
            $model->file = $filename;

            // Update tanggal upload jika file diganti
            $model->tanggalUpload = Carbon::now();
        }

        $model->save();

        return redirect('admin/profil')->with('success', 'Berkas Profil berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = Profil::findOrFail($id);

        if (File::exists(public_path('storage/uploads/profil/' . $model->file))) {
            File::delete(public_path('storage/uploads/profil/' . $model->file));
        }

        $model->delete();

        return redirect('admin/profil')->with('success', 'Berkas Profil berhasil dihapus.');
    }

    public function download($id)
    {
        $this->checkAccess();
        $model = Profil::findOrFail($id);
        $filePath = public_path('storage/uploads/profil/' . $model->file);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect('admin/profil')->with('error', 'File fisik tidak ditemukan di server.');
    }
}
