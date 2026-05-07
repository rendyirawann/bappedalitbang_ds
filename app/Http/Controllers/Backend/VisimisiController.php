<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Visimisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisimisiController extends Controller
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
        $visimisis = Visimisi::orderBy('id', 'desc')->get();
        return view('backend.visimisi.index', compact('visimisis'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'visiJudul' => 'required',
            'visiTeks'  => 'required',
            'misiJudul' => 'required',
            'misiTeks'  => 'required',
        ]);

        Visimisi::create($request->all());

        // FIX: Redirect eksplisit ke URL admin/visimisi
        return redirect('admin/visimisi')->with('success', 'Data Visi & Misi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'visiJudul' => 'required',
            'visiTeks'  => 'required',
            'misiJudul' => 'required',
            'misiTeks'  => 'required',
        ]);

        $model = Visimisi::findOrFail($id);
        $model->update($request->all());

        // FIX: Redirect eksplisit ke URL admin/visimisi
        return redirect('admin/visimisi')->with('success', 'Data Visi & Misi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $model = Visimisi::findOrFail($id);
        $model->delete();

        // FIX: Redirect eksplisit ke URL admin/visimisi
        return redirect('admin/visimisi')->with('success', 'Data Visi & Misi berhasil dihapus.');
    }
}
