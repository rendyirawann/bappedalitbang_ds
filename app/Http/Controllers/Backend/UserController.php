<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        $users = User::with('bidang')->get();
        $bidangs = Bidang::all();
        return view('backend.user.index', compact('users', 'bidangs'));
    }

    public function create()
    {
        $this->checkAccess();
        $bidangs = Bidang::all();
        return view('backend.user.create', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'status' => 'required',
            'bidang_id' => 'nullable|exists:bidang,id',
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'bidang_id' => $request->bidang_id,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id)
    {
        $this->checkAccess();
        $user = User::with('bidang')->findOrFail($id);
        return view('backend.user.show', compact('user'));
    }

    public function edit($id)
    {
        $this->checkAccess();
        $user = User::findOrFail($id);
        $bidangs = Bidang::all();
        return view('backend.user.edit', compact('user', 'bidangs'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAccess();
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $id . ',id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'password' => 'nullable|min:8',
            'status' => 'required',
            'bidang_id' => 'nullable|exists:bidang,id',
        ]);

        $data = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'bidang_id' => $request->bidang_id,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $user = User::findOrFail($id);
        
        if ($user->username === 'developer') {
            return back()->with('error', 'User Developer tidak dapat dihapus.');
        }

        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
