<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BeritaAlt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class BeritaAltController extends Controller
{
    private function checkAccess()
    {
        $user = Auth::user();
        if (!in_array($user->username, ['developer', 'admin', 'operator'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'berita_id' => 'required|integer',
            'file_docs' => 'required|array',
            'file_docs.*' => 'required|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        if ($request->hasFile('file_docs')) {
            foreach ($request->file('file_docs') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/uploads/berita_alt'), $filename);

                BeritaAlt::create([
                    'berita_id' => $request->berita_id,
                    'file' => $filename
                ]);
            }
        }

        return redirect()->route('admin.berita.show', $request->berita_id)
            ->with('success', 'Gambar tambahan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        $model = BeritaAlt::findOrFail($id);

        if ($request->hasFile('file')) {
            if (File::exists(public_path('storage/uploads/berita_alt/' . $model->file))) {
                File::delete(public_path('storage/uploads/berita_alt/' . $model->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/berita_alt'), $filename);

            $model->file = $filename;
            $model->save();
        }

        return redirect()->route('admin.berita.show', $model->berita_id)
            ->with('success', 'Gambar tambahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = BeritaAlt::findOrFail($id);
        $berita_id = $model->berita_id;

        if (File::exists(public_path('storage/uploads/berita_alt/' . $model->file))) {
            File::delete(public_path('storage/uploads/berita_alt/' . $model->file));
        }

        $model->delete();

        return redirect()->route('admin.berita.show', $berita_id)
            ->with('success', 'Gambar tambahan berhasil dihapus.');
    }

    public function download($id)
    {
        $this->checkAccess();
        $model = BeritaAlt::findOrFail($id);
        $filePath = public_path('storage/uploads/berita_alt/' . $model->file);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->route('admin.berita.show', $model->berita_id)
            ->with('error', 'File gambar fisik tidak ditemukan di server.');
    }
}
