@extends('backend.layouts.auth')

@section('title', 'Login Administrator')

@push('styles')
    <style>
        /* 1. RESET BACKGROUND & ATUR LAYOUT SPLIT-SCREEN (Kiri-Kanan) */
        body#login_bg {
            background: #f4f7f6;
            /* Warna dasar halaman */
        }

        #login {
            display: flex;
            min-height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        /* 2. STYLING ASIDE (Panel Kiri - Form Login - Tetap Putih Rapi) */
        #login aside {
            position: relative !important;
            width: 100%;
            max-width: 480px;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
            z-index: 10;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .admin-branding_wrapper {
            text-align: left;
            padding: 10px 0 30px 0;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 40px;
            display: block;
            text-decoration: none !important;
        }

        .brand-top_section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-top_section img {
            width: 45px;
            height: auto;
        }

        .brand-text_block {
            line-height: 1.2;
            font-family: 'Poppins', sans-serif;
        }

        .brand-text_block .st {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            display: block;
        }

        /* Kita pertahankan biru gelap untuk teks branding di kiri agar tegas di atas putih */
        .brand-text_block .bt {
            font-size: 1.2rem;
            font-weight: 800;
            color: #002299;
            display: block;
        }

        /* Tombol Login - Menggunakan Biru Korporat */
        .btn_1.rounded {
            background: linear-gradient(to right, #004de6, #007bff) !important;
            /* Biru Baru */
            color: #fff !important;
            border: none !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            transition: 0.3s !important;
        }

        .btn_1.rounded:hover {
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4) !important;
            transform: translateY(-2px) !important;
        }

        #login aside figure {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* =======================================================
               3. PANEL KANAN (DIUBAH JADI BIRU KORPORAT CERAH)
               ======================================================= */
        .right-panel {
            flex-grow: 1;
            /* GANTI: Dari Navy Tua ke Biru Korporat (Cerah tapi Formal) */
            background: linear-gradient(135deg, #004de6 0%, #007bff 100%);
            position: relative;
            display: none;
            /* Disembunyikan di HP */
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 50px;
            text-align: center;
            overflow: hidden;
        }

        /* Tampil hanya di layar besar (Desktop/Tablet) */
        @media (min-width: 992px) {
            .right-panel {
                display: flex;
            }
        }

        /* Pola Titik (Dot Grid) dikurangi sedikit transparansinya agar tidak terlalu rame di warna terang */
        .right-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 2px, transparent 2px);
            background-size: 40px 40px;
            z-index: 1;
        }

        /* Lingkaran Dekorasi Disesuaikan */
        .circle-decoration {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .circle-1 {
            width: 600px;
            height: 600px;
            top: -150px;
            right: -150px;
        }

        .circle-2 {
            width: 400px;
            height: 400px;
            bottom: -100px;
            left: -100px;
        }

        /* Konten Teks & Logo Bappeda Besar */
        .rp-content {
            z-index: 2;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .rp-content img.main-logo {
            width: 150px;
            margin-bottom: 35px;
            /* Bayangan diperhalus agar tidak terlalu kasar di warna terang */
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
            animation: floatLogo 5s ease-in-out infinite;
        }

        .rp-content h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: 3px;
            margin-bottom: 5px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .rp-content p {
            font-size: 1.2rem;
            font-weight: 400;
            letter-spacing: 2px;
            color: #ffffff;
            /* GANTI: Dari biru muda ke putih solid agar jernih */
            text-transform: uppercase;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Jejeran Logo Slogan di Bawah */
        .rp-slogans {
            z-index: 2;
            margin-top: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            background: rgba(255, 255, 255, 0.1);
            /* Sedikit lebih tebal agar kelihatan di warna terang */
            padding: 20px 40px;
            border-radius: 100px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .rp-slogans img {
            height: 40px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }

        /* Animasi Melayang untuk Logo */
        @keyframes floatLogo {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0);
            }
        }

        /* Loading Overlay */
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99999;
        }

        #loading-overlay:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            margin-top: -20px;
            margin-left: -20px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div id="loading-overlay"></div>
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>

    <div id="login">

        <aside>
            <a href="{{ route('home') }}" class="admin-branding_wrapper">
                <div class="brand-top_section">
                    <img src="{{ asset('udema/bappeda/bappeda.png') }}" alt="Logo Deli Serdang">
                    <div class="brand-text_block">
                        <span class="st">ADMIN PORTAL</span>
                        <span class="bt">BAPPEDALITBANG</span>
                    </div>
                </div>
            </a>

            <form id="login-form" action="{{ url('admin/login') }}" method="POST" autocomplete="off" style="flex-grow: 1;">
                @csrf

                <div class="mb-4">
                    <h4 class="fw-bold mb-1" style="color: #333;">Selamat Datang!</h4>
                    <p class="text-muted small">Silakan masuk ke akun Anda.</p>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger small p-2 rounded">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <span class="input">
                    <input type="text" name="username" class="input_field @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" autocomplete="off" required>
                    <label class="input_label">
                        <span class="input__label-content">Username / Email</span>
                    </label>
                </span>
                @error('username')
                    <div class="text-danger small mb-3" style="margin-top:-15px; font-size: 0.8rem;">{{ $message }}</div>
                @enderror

                <span class="input mt-3">
                    <input type="password" name="password" id="password-input"
                        class="input_field @error('password') is-invalid @enderror" autocomplete="new-password" required>
                    <label class="input_label">
                        <span class="input__label-content">Password</span>
                    </label>
                </span>
                @error('password')
                    <div class="text-danger small mb-3" style="margin-top:-15px; font-size: 0.8rem;">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                    <div class="form-check text-start">
                        <input type="checkbox" class="form-check-input" id="show-password" onclick="togglePassword()">
                        <label class="form-check-label text-muted" style="font-size:13px;" for="show-password">Lihat
                            Sandi</label>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <button type="submit" class="btn_1 rounded full-width">MASUK SISTEM</button>
                </div>
            </form>

            <div class="copy mt-auto text-center" style="border-top: 1px solid #eee; padding-top: 20px;">
                Copyright &copy; {{ date('Y') }} Bappedalitbang Kab. Deli Serdang
            </div>
        </aside>


        <div class="right-panel">

            <div class="circle-decoration circle-1"></div>
            <div class="circle-decoration circle-2"></div>

            <div class="rp-content">
                <img src="{{ asset('udema/bappeda/bappeda.png') }}" alt="Logo Bappeda Besar" class="main-logo">
                <h1>BAPPEDALITBANG</h1>
                <p>Pemerintah Kabupaten Deli Serdang</p>
            </div>

            <div class="rp-slogans">
                <img src="{{ asset('udema/img/logo/hastag_deli_serdang_sehat.png') }}" alt="Slogan Sehat">
                <img src="{{ asset('udema/img/logo/berakhlak_logo.png') }}" alt="Berakhlak">
                <img src="{{ asset('udema/img/logo/bangga_melayani_bangsa.png') }}" alt="Bangga Melayani">
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Efek loading berjalan saat tombol ditekan
        $(document).on('submit', 'form#login-form', function() {
            $('#loading-overlay').show();
        });
    </script>
@endpush
