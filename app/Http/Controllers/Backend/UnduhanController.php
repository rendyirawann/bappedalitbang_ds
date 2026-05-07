<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Unduhan; // Pastikan Model Unduhan sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnduhanController extends Controller
{
    private function checkAccess()
    {
        $user = Auth::user();
        // Di Yii2 Anda, operator juga diizinkan mengakses Unduhan
        if (!in_array($user->username, ['developer', 'admin', 'operator'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        // Optimasi: Hanya memanggil id dan namaFile
        $unduhans = Unduhan::select('id', 'namaFile', 'created_at')->orderBy('id', 'desc')->get();
        return view('backend.unduhan.index', compact('unduhans'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
        ]);

        Unduhan::create([
            'namaFile' => $request->namaFile
        ]);

        return redirect('admin/unduhan')->with('success', 'Folder Unduhan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $this->checkAccess();

        $unduhan = Unduhan::findOrFail($id);

        // Ambil semua file yang terikat dengan kategori ini
        // Pastikan Model UnduhanFile sudah dibuat!
        $files = \App\Models\UnduhanFile::where('refunduhan_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.unduhan.show', compact('unduhan', 'files'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
        ]);

        $model = Unduhan::findOrFail($id);
        $model->update([
            'namaFile' => $request->namaFile
        ]);

        return redirect('admin/unduhan')->with('success', 'Folder Unduhan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = Unduhan::findOrFail($id);
        $model->delete();

        return redirect('admin/unduhan')->with('success', 'Folder Unduhan berhasil dihapus.');
    }
}
