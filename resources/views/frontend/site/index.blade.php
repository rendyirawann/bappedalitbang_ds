@extends('frontend.layouts.app')

@section('title', 'Website Bappedalitbang Deli Serdang')

@push('styles')
    <style>
        /* =========================================================
                                       0. EFEK NAVBAR MELUNCUR (Navbar disembunyikan saat intro)
                                       ========================================================= */
        body.intro-active .nav-master-container {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .nav-master-container {
            transition: transform 1s cubic-bezier(0.86, 0, 0.07, 1), opacity 1s ease !important;
        }

        /* =========================================================
                                       1. CINEMATIC WELCOME SCREEN (INTRO OVERLAY)
                                       ========================================================= */
        body.intro-active {
            overflow: hidden !important;
        }

        .intro-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99999999 !important;
            background-color: #000;
            /* Dasar hitam */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: opacity 1s cubic-bezier(0.86, 0, 0.07, 1),
                visibility 1s,
                transform 1s cubic-bezier(0.86, 0, 0.07, 1);
        }

        .intro-overlay.hidden-intro {
            opacity: 0;
            visibility: hidden;
            transform: scale(1.1);
        }

        .intro-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        /* FILTER BARU: Jernih di atas, sedikit gelap di bawah agar teks terbaca */
        .intro-dark-mask {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.6) 100%);
            z-index: 2;
        }

        .intro-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .intro-logo {
            width: 110px;
            margin-bottom: 30px;
            filter: drop-shadow(0 0 20px rgba(0, 0, 0, 0.6));
            animation: fadeInDown 1.5s ease forwards;
            opacity: 0;
            transform: translateY(-30px);
        }

        .intro-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: 4px;
            margin-bottom: 5px;
            text-transform: uppercase;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1.2s ease forwards 0.5s;
        }

        .intro-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            font-weight: 400;
            letter-spacing: 2px;
            color: #ffffff;
            text-transform: uppercase;
            margin-bottom: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1.2s ease forwards 0.8s;
        }

        .intro-divider {
            width: 0;
            height: 2px;
            background: #ffffff;
            margin: 30px auto;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            animation: drawLine 1s ease forwards 1.2s;
        }

        .intro-click-area {
            position: absolute;
            bottom: 50px;
            z-index: 3;
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            opacity: 0;
            animation: fadeIn 1s ease forwards 2s;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }

        .mouse-icon {
            width: 30px;
            height: 45px;
            border: 2px solid #fff;
            border-radius: 20px;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .mouse-wheel {
            width: 4px;
            height: 8px;
            background: #fff;
            border-radius: 2px;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            animation: scrollWheel 2s infinite;
        }

        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 0.9;
            }
        }

        @keyframes drawLine {
            to {
                width: 100px;
            }
        }

        @keyframes scrollWheel {
            0% {
                top: 8px;
                opacity: 1;
            }

            100% {
                top: 25px;
                opacity: 0;
            }
        }

        /* =========================================================
                                       2. KONTEN BERANDA UTAMA
                                       ========================================================= */
        .hero-carousel {
            position: relative;
            width: 100%;
        }

        .hero-carousel .carousel-item {
            height: 85vh;
            min-height: 500px;
            background-color: #000;
        }

        .hero-carousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.65;
            transition: transform 10s ease;
        }

        .hero-carousel .carousel-item.active img {
            transform: scale(1.05);
        }

        .hero-carousel .carousel-caption {
            bottom: 30%;
            z-index: 10;
        }

        .hero-carousel .carousel-caption h2 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.5s;
        }

        .hero-carousel .carousel-caption p {
            font-size: 1.5rem;
            color: #f8f9fa;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.8s;
        }

        .hero-carousel .btn-explore {
            background-color: #487ec9;
            color: white;
            padding: 12px 35px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInBtn 0.8s forwards 1.2s;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
        }

        .hero-carousel .btn-explore:hover {
            background-color: #8caedf;
            transform: translateY(-3px);
            color: white;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInBtn {
            to {
                opacity: 1;
            }
        }

        .announcement-wrapper {
            position: relative;
            margin-top: -45px;
            z-index: 20;
            padding: 0 15px;
        }

        .announcement-bar {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px 25px;
            font-size: 1rem;
            color: #444;
            display: flex;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f1f1;
        }

        .announcement-badge {
            background: linear-gradient(to right, #002299, #0039ff);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1px;
            margin-right: 20px;
            box-shadow: 0 4px 10px rgba(72, 126, 201, 0.3);
            white-space: nowrap;
        }

        .feature-section {
            padding: 80px 0 50px;
            background-color: #fcfcfc;
        }

        .feature-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #f1f1f1;
            border-bottom: 5px solid transparent;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .feature-card:hover {
            transform: translateY(-12px);
            border-bottom: 5px solid #487ec9;
            box-shadow: 0 20px 40px rgba(72, 126, 201, 0.15);
        }

        .feature-icon {
            width: 75px;
            margin: 0 auto 25px auto;
            transition: transform 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .feature-card h4 {
            font-weight: 800;
            color: #222;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }

        .feature-card p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0;
            line-height: 1.6;
        }

        .news-section {
            padding: 60px 0;
        }

        .news-card-home {
            display: flex;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f8f9fa;
            text-decoration: none !important;
            height: calc(100% - 30px);
        }

        .news-card-home:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .news-img-wrap {
            width: 40%;
            position: relative;
            overflow: hidden;
        }

        .news-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .news-card-home:hover .news-img-wrap img {
            transform: scale(1.08);
        }

        .news-date-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(to right, #002299, #0039ff);
            color: white;
            padding: 8px 12px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .news-date-badge strong {
            display: block;
            font-size: 1.2rem;
            line-height: 1;
        }

        .news-date-badge span {
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .news-content {
            width: 60%;
            padding: 25px;
            display: flex;
            flex-direction: column;
        }

        .news-content .badge-bidang {
            align-self: flex-start;
            background: #f0f6ff;
            color: #487ec9;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
            border: 1px solid #dceaf7;
        }

        .news-content h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 12px;
            line-height: 1.4;
            transition: color 0.3s;
        }

        .news-card-home:hover .news-content h3 {
            color: #487ec9;
        }

        .news-content p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0;
            line-height: 1.6;
        }

        .cta-visi-modern {
            background: linear-gradient(to right, #002299, #0039ff);
            border-radius: 20px;
            padding: 60px 50px;
            color: white;
            position: relative;
            overflow: hidden;
            margin: 40px 0 80px;
            box-shadow: 0 20px 40px rgba(72, 126, 201, 0.25);
            text-align: center;
        }

        .cta-visi-modern::before {
            content: '\f0eb';
            font-family: 'FontAwesome';
            position: absolute;
            font-size: 200px;
            color: rgba(255, 255, 255, 0.1);
            top: -50px;
            left: -30px;
            transform: rotate(-15deg);
        }

        .cta-visi-modern h3 {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cta-visi-modern p {
            font-size: 1.2rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.95);
            max-width: 800px;
            margin: 0 auto 30px;
            position: relative;
            z-index: 2;
            font-style: italic;
        }

        .btn-modern-white {
            background: #fff;
            color: #487ec9;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            display: inline-block;
            position: relative;
            z-index: 2;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .btn-modern-white:hover {
            background: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
            color: #3562a0;
        }

        @media (max-width: 768px) {
            .intro-title {
                font-size: 2rem;
                letter-spacing: 2px;
            }

            .intro-subtitle {
                font-size: 0.9rem;
            }

            .hero-carousel .carousel-caption h2 {
                font-size: 2rem;
            }

            .hero-carousel .carousel-caption p {
                font-size: 1.1rem;
            }

            .hero-carousel .carousel-item {
                height: 60vh;
            }

            .announcement-wrapper {
                margin-top: -30px;
            }

            .announcement-bar {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .announcement-badge {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .news-card-home {
                flex-direction: column;
            }

            .news-img-wrap,
            .news-content {
                width: 100%;
            }

            .news-img-wrap {
                height: 200px;
            }

            .cta-visi-modern {
                padding: 40px 25px;
            }

            .cta-visi-modern h3 {
                font-size: 1.8rem;
            }
        }
    </style>
@endpush

@section('content')

    <script>
        document.body.classList.add('intro-active');
    </script>

    <div class="intro-overlay" id="introOverlay">

        <video autoplay muted loop playsinline class="intro-video">
            <source src="{{ asset('udema/video/mars.mp4') }}" type="video/mp4">
        </video>

        <div class="intro-dark-mask"></div>

        <div class="intro-content">
            <img src="{{ asset('udema/bappeda/bappeda.png') }}" alt="Logo Bappeda" class="intro-logo">
            <h1 class="intro-title">WEBSITE</h1>
            <h1 class="intro-title">BAPPEDALITBANG</h1>
            <p class="intro-subtitle">Kabupaten Deli Serdang</p>
            <div class="intro-divider"></div>
        </div>

        <div class="intro-click-area">
            <div class="mouse-icon">
                <div class="mouse-wheel"></div>
            </div>
            <span>Klik Di Mana Saja</span>
        </div>
    </div>
    <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-pause="false">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="6000">
                <img src="{{ asset('udema/bappeda/ds-new2025_bupati.png') }}" alt="Bupati Deli Serdang">
            </div>

            <div class="carousel-item" data-bs-interval="6000">
                <img src="{{ asset('udema/bappeda/ds-new2025_remus.png') }}" alt="Kegiatan Bappeda">
                <div class="carousel-caption">
                    <h2>Perencanaan Inklusif</h2>
                    <p>Mewujudkan Pembangunan Daerah yang Berkelanjutan</p>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="6000">
                <img src="{{ asset('udema/bappeda/simona.jpg') }}" alt="SIMONALISA">
                <div class="carousel-caption">
                    <h2>Aplikasi eSakip SIMONALISA</h2>
                    <p>Sistem Akuntabilitas Kinerja Instansi Pemerintah Elektronik</p>
                    <a href="https://esakipsimonalisa.deliserdangkab.go.id/" target="_blank" rel="noopener noreferrer"
                        class="btn-explore">
                        Explore Sekarang
                    </a>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container announcement-wrapper">
        <div class="announcement-bar">
            <span class="announcement-badge"><i class="bi bi-info-circle-fill me-1"></i> INFO PENTING</span>
            <span style="flex-grow: 1; line-height: 1.6;">
                <strong>Selamat datang di Website Bappedalitbang Kabupaten Deli Serdang.</strong> Kami berkomitmen untuk
                mewujudkan perencanaan pembangunan daerah yang inklusif dan berkelanjutan.
            </span>
        </div>
    </div>

    <div class="feature-section">
        <div class="container">
            <div class="main_title_2 mb-5">
                <span><em></em></span>
                <h2>Dokumen Perencanaan</h2>
                <p>Akses cepat portal data perencanaan pembangunan daerah</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman"
                        target="_blank" rel="noreferrer noopener" class="text-decoration-none">
                        <div class="feature-card">
                            <img src="{{ asset('udema/bappeda/icons8-planner-100.png') }}" alt="RKPD"
                                class="feature-icon">
                            <h4>RKPD</h4>
                            <p>Rencana Kerja Pemerintah Daerah</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <a href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman"
                        target="_blank" rel="noreferrer noopener" class="text-decoration-none">
                        <div class="feature-card">
                            <img src="{{ asset('udema/bappeda/icons8-goal-100.png') }}" alt="RENSTRA" class="feature-icon">
                            <h4>RENSTRA</h4>
                            <p>Rencana Strategis Pemerintah Daerah</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman"
                        target="_blank" rel="noreferrer noopener" class="text-decoration-none">
                        <div class="feature-card">
                            <img src="{{ asset('udema/bappeda/icons8-document-100.png') }}" alt="RPJMD"
                                class="feature-icon">
                            <h4>RPJMD</h4>
                            <p>Rencana Pembangunan Jangka Menengah Daerah</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <a href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman"
                        target="_blank" rel="noreferrer noopener" class="text-decoration-none">
                        <div class="feature-card">
                            <img src="{{ asset('udema/bappeda/icons8-graph-100.png') }}" alt="RPJPD"
                                class="feature-icon">
                            <h4>RPJPD</h4>
                            <p>Rencana Pembangunan Jangka Panjang Daerah</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="news-section bg_color_1">
        <div class="container">
            <div class="main_title_2">
                <span><em></em></span>
                <h2>Berita Perencanaan</h2>
                <p>Informasi terbaru seputar kegiatan Bappedalitbang Deli Serdang</p>
            </div>

            <div class="row">
                @forelse ($latestBerita as $berita)
                    <div class="col-lg-6 wow fadeIn">
                        <a class="news-card-home" href="{{ url('berita/' . $berita->id) }}">
                            <div class="news-img-wrap">
                                <img src="{{ asset('storage/uploads/berita/' . $berita->file) }}"
                                    alt="{{ $berita->judulBerita }}">
                                <div class="news-date-badge">
                                    <strong>{{ $berita->tgl_berita ? $berita->tgl_berita->format('d') : '' }}</strong>
                                    <span>{{ $berita->tgl_berita ? $berita->tgl_berita->format('M') : '' }}</span>
                                </div>
                            </div>
                            <div class="news-content">
                                <span class="badge-bidang"><i class="bi bi-folder2-open me-1"></i>
                                    {{ $berita->bidang->bidang ?? 'Umum' }}</span>
                                <h3>{{ \Illuminate\Support\Str::limit($berita->judulBerita, 50, '...') }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->isiBerita), 80, '...') }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center w-100">
                        <img src="{{ asset('udema/bappeda/no-data.png') }}" alt="No Data" width="100">
                        <p class="text-muted mt-3">Belum ada berita terbaru.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ url('berita') }}" class="btn_1 rounded outline">Lihat Semua Berita <i
                        class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="cta-visi-modern wow zoomIn" data-wow-duration="0.8s">
            <h3>{!! $visiMisi->visiJudul ?? 'Visi Bappedalitbang' !!}</h3>
            <p>"{!! strip_tags($visiMisi->visiTeks ?? 'Teks visi belum tersedia.') !!}"</p>
            <a href="{{ url('visimisi') }}" class="btn-modern-white">Visi Misi Deli Serdang <i
                    class="bi bi-arrow-right-circle ms-2"></i></a>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const introOverlay = document.getElementById('introOverlay');

            // Hapus intro dan mainkan animasi slide-down pada navbar saat layar diklik
            introOverlay.addEventListener('click', function() {
                this.classList.add('hidden-intro');
                document.body.classList.remove('intro-active');

                // Hapus overlay dari memori setelah animasinya selesai
                setTimeout(() => {
                    this.style.display = 'none';
                }, 1000);
            });
        });
    </script>
@endpush
