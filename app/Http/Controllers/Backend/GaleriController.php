<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class GaleriController extends Controller
{
    private function checkAccess()
    {
        $user = Auth::user();
        if (!in_array($user->username, ['developer', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        // OPTIMASI QUERY: Hanya panggil kolom id, namaFile, dan file. Menghemat memori RAM server!
        $galeris = Galeri::select('id', 'namaFile', 'file')->orderBy('id', 'desc')->get();
        return view('backend.galeri.index', compact('galeris'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
            'file_docs' => 'required|array',
            'file_docs.*' => 'image|mimes:jpeg,png,jpg|max:5048'
        ]);

        if ($request->hasFile('file_docs')) {
            foreach ($request->file('file_docs') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/uploads/galeri'), $filename);

                Galeri::create([
                    'namaFile' => $request->namaFile,
                    'file' => $filename
                ]);
            }
        }

        return redirect('admin/galeri')->with('success', 'Data Galeri berhasil ditambahkan (Multiple Upload).');
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        $model = Galeri::findOrFail($id);
        $model->namaFile = $request->namaFile;

        if ($request->hasFile('file')) {
            if (File::exists(public_path('storage/uploads/galeri/' . $model->file))) {
                File::delete(public_path('storage/uploads/galeri/' . $model->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/galeri'), $filename);
            $model->file = $filename;
        }

        $model->save();

        return redirect('admin/galeri')->with('success', 'Data Galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = Galeri::findOrFail($id);

        if (File::exists(public_path('storage/uploads/galeri/' . $model->file))) {
            File::delete(public_path('storage/uploads/galeri/' . $model->file));
        }

        $model->delete();

        return redirect('admin/galeri')->with('success', 'Data Galeri berhasil dihapus.');
    }

    public function download($id)
    {
        $this->checkAccess();
        $model = Galeri::findOrFail($id);
        $filePath = public_path('storage/uploads/galeri/' . $model->file);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect('admin/galeri')->with('error', 'File fisik tidak ditemukan di server.');
    }
}
