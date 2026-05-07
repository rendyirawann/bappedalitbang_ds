<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login admin.
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    /**
     * Proses pengecekan login (Username/Email & Password)
     */
    public function login(Request $request)
    {
        // 1. Validasi input wajib diisi
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username atau Email tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        // 2. Deteksi Pintar: Apakah user mengetik Email atau Username?
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Siapkan kredensial
        $credentials = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        // 4. Lakukan percobaan Login
        if (Auth::attempt($credentials)) {

            // Opsional: Cek apakah status user = 10 (Aktif dari bawaan Yii2)
            if (Auth::user()->status != 10) {
                Auth::logout();
                return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi Administrator.');
            }

            // Jika berhasil dan aktif, buat ulang sesi untuk keamanan
            $request->session()->regenerate();

            // Arahkan ke halaman Dashboard Admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // 5. Jika gagal (Username/Password salah)
        return back()->with('error', 'Username atau Password yang Anda masukkan salah!')
            ->withInput($request->only('username')); // Kembalikan username yang diketik agar tidak perlu ngetik ulang
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Lempar kembali ke halaman login dengan pesan sukses
        return redirect('/admin/login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
