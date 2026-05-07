<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\PegawaiEselon;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    private function checkAccess()
    {
        if (!in_array(Auth::user()->username, ['developer', 'admin'])) {
            abort(403, 'Hanya Administrator yang dapat mengakses menu ini.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        $pegawais = Pegawai::with(['bidang', 'pegawaiEselon', 'title'])->get();
        $bidangs = Bidang::all();
        $eselons = PegawaiEselon::all();
        $titles = Title::all();
        return view('backend.pegawai.index', compact('pegawais', 'bidangs', 'eselons', 'titles'));
    }

    public function create()
    {
        $this->checkAccess();
        $bidangs = Bidang::all();
        $eselons = PegawaiEselon::all();
        $titles = Title::all();
        return view('backend.pegawai.create', compact('bidangs', 'eselons', 'titles'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'statusAparatur' => 'required',
            'namaLengkap' => 'required',
            'nip' => 'nullable|unique:pegawai,nip',
            'eselon' => 'nullable|exists:pegawai_eselon,id',
            'kodeBidang' => 'nullable|exists:bidang,id',
            'kodeTitle' => 'nullable|exists:title,id',
            'no_hp' => 'nullable',
        ], [
            'statusAparatur.required' => 'Status Aparatur wajib diisi.',
            'namaLengkap.required' => 'Nama Lengkap wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ]);

        Pegawai::create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => 'Data Pegawai berhasil ditambahkan.']);
        }

        return redirect()->route('admin.pegawai.index')->with('success', 'Data Pegawai berhasil ditambahkan.');
    }

    public function show($id)
    {
        $this->checkAccess();
        $pegawai = Pegawai::with(['bidang', 'pegawaiEselon', 'title'])->findOrFail($id);
        return view('backend.pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $this->checkAccess();
        $pegawai = Pegawai::findOrFail($id);
        $bidangs = Bidang::all();
        $eselons = PegawaiEselon::all();
        $titles = Title::all();
        return view('backend.pegawai.edit', compact('pegawai', 'bidangs', 'eselons', 'titles'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'statusAparatur' => 'required',
            'namaLengkap' => 'required',
            'nip' => 'nullable|unique:pegawai,nip,' . $id . ',id',
            'eselon' => 'nullable|exists:pegawai_eselon,id',
            'kodeBidang' => 'nullable|exists:bidang,id',
            'kodeTitle' => 'nullable|exists:title,id',
            'no_hp' => 'nullable',
        ], [
            'statusAparatur.required' => 'Status Aparatur wajib diisi.',
            'namaLengkap.required' => 'Nama Lengkap wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ]);

        $pegawai->update($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => 'Data Pegawai berhasil diperbarui.']);
        }

        return redirect()->route('admin.pegawai.index')->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect()->route('admin.pegawai.index')->with('success', 'Data Pegawai berhasil dihapus.');
    }
}
