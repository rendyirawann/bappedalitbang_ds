<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BeritaAltController;
use App\Http\Controllers\Backend\BeritaController as BackendBeritaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GaleriController as BackendGaleriController;
use App\Http\Controllers\Backend\ProfilController;
use App\Http\Controllers\Backend\StrukturController as BackendStrukturController;
use App\Http\Controllers\Backend\UnduhanController as BackendUnduhanController;
use App\Http\Controllers\Backend\UnduhanFileController;
use App\Http\Controllers\Backend\VisimisiController as BackendVisimisiController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PegawaiController;
use Illuminate\Support\Facades\Route;

// Controller Frontend
use App\Http\Controllers\Frontend\SiteController;
use App\Http\Controllers\Frontend\VisimisiController;
use App\Http\Controllers\Frontend\StrukturController;
use App\Http\Controllers\Frontend\UnduhanController;
use App\Http\Controllers\Frontend\GaleriController;
use App\Http\Controllers\Frontend\BeritaController;

// ==========================================
// RUTE FRONTEND (PUBLIK)
// ==========================================
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/visimisi', [VisimisiController::class, 'index'])->name('visimisi.index');
Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur.index');
Route::get('/unduhan', [UnduhanController::class, 'index'])->name('unduhan.index');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Rute Berita Frontend (Tetap menggunakan nama bawaan)
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/bidang/{bidang_id}', [BeritaController::class, 'indexBidang'])->name('berita.bidang');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');


// ==========================================
// RUTE BACKEND (ADMIN)
// ==========================================
// KUNCI SOLUSINYA ADA DI SINI: ->name('admin.')
Route::prefix('admin')->name('admin.')->group(function () {

    // Jika belum login dan buka /admin, lempar ke login
    Route::redirect('/', '/admin/login');

    // -- RUTE UNTUK GUEST (Belum Login) --
    Route::middleware('guest')->group(function () {
        // Perhatikan: kita hapus awalan 'admin.' di name() karena sudah ter-cover oleh grup
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // -- RUTE UNTUK AUTH (Sudah Login) --
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource Struktur Anggota
        Route::resource('struktur', BackendStrukturController::class);
        Route::get('struktur/{id}/download', [BackendStrukturController::class, 'download'])->name('struktur.download');

        // Resource Visi Misi
        Route::resource('visimisi', BackendVisimisiController::class);

        // Resource Galeri
        Route::resource('galeri', BackendGaleriController::class)->except(['create', 'show', 'edit']);
        Route::get('galeri/{id}/download', [BackendGaleriController::class, 'download'])->name('galeri.download');

        // Resource Profil
        Route::resource('profil', ProfilController::class)->except(['create', 'show', 'edit']);
        Route::get('profil/{id}/download', [ProfilController::class, 'download'])->name('profil.download');

        // Resource Unduhan & Unduhan File
        Route::resource('unduhan', BackendUnduhanController::class)->except(['create', 'edit']);
        Route::resource('unduhan-file', UnduhanFileController::class)->except(['index', 'create', 'show', 'edit']);
        Route::get('unduhan-file/{id}/download', [UnduhanFileController::class, 'download'])->name('unduhan-file.download');

        // Resource Berita & Berita Alt
        Route::resource('berita', BackendBeritaController::class);
        Route::get('berita/{id}/download', [BackendBeritaController::class, 'download'])->name('berita.download');
        Route::get('berita/{id}/preview', [BackendBeritaController::class, 'preview'])->name('berita.preview');

        Route::resource('berita-alt', BeritaAltController::class)->except(['index', 'create', 'show', 'edit']);
        Route::get('berita-alt/{id}/download', [BeritaAltController::class, 'download'])->name('berita-alt.download');

        // Change Auth (Ganti Password)
        Route::get('/change-auth', [ProfileController::class, 'index'])->name('change-auth');
        Route::post('/change-auth', [ProfileController::class, 'update'])->name('change-auth.update');

        // User Management
        Route::resource('user', UserController::class);

        // Pegawai Management
        Route::resource('pegawai', PegawaiController::class);
    });
});
