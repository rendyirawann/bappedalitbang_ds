<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UnduhanFile; // Pastikan Model UnduhanFile sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UnduhanFileController extends Controller
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
            'refunduhan_id' => 'required|integer',
            'file_docs' => 'required|array',
            'file_docs.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpeg,png,jpg|max:10240' // Maks 10MB
        ]);

        if ($request->hasFile('file_docs')) {
            foreach ($request->file('file_docs') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/uploads/unduhan'), $filename);

                UnduhanFile::create([
                    'refunduhan_id' => $request->refunduhan_id,
                    'file' => $filename,
                    'tanggalUpload' => Carbon::now()
                ]);
            }
        }

        return redirect()->route('unduhan.show', $request->refunduhan_id)
            ->with('success', 'Berkas berhasil ditambahkan ke dalam folder.');
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpeg,png,jpg|max:10240'
        ]);

        $model = UnduhanFile::findOrFail($id);

        if ($request->hasFile('file')) {
            // Hapus file lama fisik
            if (File::exists(public_path('storage/uploads/unduhan/' . $model->file))) {
                File::delete(public_path('storage/uploads/unduhan/' . $model->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/unduhan'), $filename);

            $model->file = $filename;
            $model->tanggalUpload = Carbon::now();
            $model->save();
        }

        return redirect()->route('unduhan.show', $model->refunduhan_id)
            ->with('success', 'Berkas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = UnduhanFile::findOrFail($id);
        $refunduhan_id = $model->refunduhan_id;

        if (File::exists(public_path('storage/uploads/unduhan/' . $model->file))) {
            File::delete(public_path('storage/uploads/unduhan/' . $model->file));
        }

        $model->delete();

        return redirect()->route('unduhan.show', $refunduhan_id)
            ->with('success', 'Berkas berhasil dihapus.');
    }

    public function download($id)
    {
        $this->checkAccess();
        $model = UnduhanFile::findOrFail($id);
        $filePath = public_path('storage/uploads/unduhan/' . $model->file);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->route('unduhan.show', $model->refunduhan_id)
            ->with('error', 'File fisik tidak ditemukan di server.');
    }
}
