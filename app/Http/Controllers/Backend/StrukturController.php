<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Struktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class StrukturController extends Controller
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
        $strukturs = Struktur::orderBy('id', 'desc')->get();
        return view('backend.struktur.index', compact('strukturs'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        $model = new Struktur();
        $model->namaFile = $request->namaFile;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads/struktur'), $filename);
            $model->file = $filename;
        }

        $model->save();

        // FIX: Redirect eksplisit
        return redirect('admin/struktur')->with('success', 'Data Struktur berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'namaFile' => 'required',
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        $model = Struktur::findOrFail($id);
        $model->namaFile = $request->namaFile;

        if ($request->hasFile('file')) {
            if (File::exists(public_path('storage/uploads/struktur/' . $model->file))) {
                File::delete(public_path('storage/uploads/struktur/' . $model->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads/struktur'), $filename);
            $model->file = $filename;
        }

        $model->save();

        // FIX: Redirect eksplisit
        return redirect('admin/struktur')->with('success', 'Data Struktur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = Struktur::findOrFail($id);

        if (File::exists(public_path('storage/uploads/struktur/' . $model->file))) {
            File::delete(public_path('storage/uploads/struktur/' . $model->file));
        }

        $model->delete();

        // FIX: Redirect eksplisit
        return redirect('admin/struktur')->with('success', 'Data Struktur berhasil dihapus.');
    }

    public function download($id)
    {
        $this->checkAccess();
        $model = Struktur::findOrFail($id);
        $filePath = public_path('storage/uploads/struktur/' . $model->file);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        // FIX: Redirect eksplisit
        return redirect('admin/struktur')->with('error', 'File fisik tidak ditemukan di server.');
    }
}
