@extends('frontend.layouts.app')

@section('title', 'Galeri Kegiatan - Bappedalitbang Deli Serdang')

@push('styles')
    <link rel="stylesheet" href="{{ asset('udema/vendor/fancybox/fancybox.css') }}" />

    <style>
        /* === Desain Galeri Modern & Elegan === */
        .gallery-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            aspect-ratio: 4/3;
            background: #fff;
        }

        .gallery-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .gallery-card:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            bottom: -100%;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 34, 153, 0.95) 0%, rgba(0, 57, 255, 0.4) 50%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 30px 25px 25px;
            transition: bottom 0.4s ease-in-out;
        }

        .gallery-card:hover .gallery-overlay {
            bottom: 0;
        }

        .gallery-title {
            color: #ffffff;
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.4;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .gallery-icon {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.8rem;
            margin-bottom: 10px;
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.4s ease, opacity 0.4s ease;
            transition-delay: 0.1s;
        }

        .gallery-card:hover .gallery-icon {
            transform: translateY(0);
            opacity: 1;
        }

        /* === Custom CSS untuk Paginasi ala DataTables === */
        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .page-item.active .page-link {
            background-color: #0056b3;
            border-color: #0056b3;
            box-shadow: 0 4px 10px rgba(0, 86, 179, 0.3);
        }

        .page-link {
            color: #0056b3;
            border-radius: 6px !important;
            font-weight: 600;
            border: 1px solid #eaeaea;
        }

        .page-link:hover {
            background-color: #f4f8fa;
        }
    </style>
@endpush

@section('content')
    <section id="hero_in" class="general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>Galeri Kegiatan</h1>
            </div>
        </div>
    </section>

    <div class="container margin_60_35" id="gallery-wrapper">
        <div class="main_title_2">
            <span><em></em></span>
            <h2>Dokumentasi Bappedalitbang</h2>
            <p>Kumpulan foto kegiatan dan acara Bappedalitbang Kabupaten Deli Serdang</p>
        </div>

        <div id="gallery-container" style="transition: opacity 0.3s ease;">

            <div class="row">
                @forelse ($galeris as $key => $galeri)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ asset('storage/uploads/galeri/' . $galeri->file) }}" data-fancybox="gallery"
                            data-caption="{{ $galeri->namaFile }}" class="d-block text-decoration-none">

                            <div class="gallery-card">
                                <img src="{{ asset('storage/uploads/galeri/' . $galeri->file) }}"
                                    alt="{{ $galeri->namaFile }}">
                                <div class="gallery-overlay">
                                    <i class="bi bi-zoom-in gallery-icon"></i>
                                    <h4 class="gallery-title">{{ $galeri->namaFile }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center w-100 mt-5">
                        <img src="{{ asset('udema/bappeda/no-data.png') }}" alt="No Data" width="120">
                        <p class="text-muted mt-3">Belum ada dokumentasi foto kegiatan.</p>
                    </div>
                @endforelse
            </div>

            @if ($galeris->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-4 flex-column flex-md-row">
                    <div class="text-muted small mb-3 mb-md-0 fw-medium">
                        Menampilkan {{ $galeris->firstItem() ?? 0 }} sampai {{ $galeris->lastItem() ?? 0 }} dari total
                        {{ $galeris->total() }} dokumentasi
                    </div>
                    <div>
                        {{ $galeris->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('udema/vendor/fancybox/fancybox.umd.js') }}"></script>
    <script>
        // Inisialisasi Fancybox (akan tetap aktif walaupun halaman berganti via AJAX)
        Fancybox.bind('[data-fancybox="gallery"]', {
            animated: true,
            dragToClose: true,
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW", "flipX", "flipY"],
                    right: ["slideshow", "thumbs", "close"],
                },
            },
        });

        // ==========================================
        // SISTEM PAGINASI AJAX (TANPA RELOAD PAGE)
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            // Gunakan event delegation agar link paginasi yang baru dimuat tetap bisa diklik
            document.body.addEventListener('click', function(e) {
                let pageLink = e.target.closest('.pagination a');

                if (pageLink) {
                    e.preventDefault(); // Cegah browser berpindah halaman
                    let url = pageLink.href;
                    loadGalleryAjax(url);
                }
            });

            function loadGalleryAjax(url) {
                let container = document.getElementById('gallery-container');
                let wrapper = document.getElementById('gallery-wrapper');

                // 1. Berikan efek loading (transparan) agar interaktif
                container.style.opacity = '0.3';
                container.style.pointerEvents = 'none'; // Cegah klik ganda

                // 2. Ambil data halaman baru dari server
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // 3. Bedah HTML yang diterima dari server
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');

                        // 4. Ambil khusus bagian <div id="gallery-container"> saja
                        let newContent = doc.getElementById('gallery-container').innerHTML;

                        // 5. Ganti isi galeri yang lama dengan yang baru
                        container.innerHTML = newContent;

                        // 6. Kembalikan opacity seperti semula
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';

                        // 7. Scroll otomatis ke judul Galeri dengan mulus (smooth)
                        window.scrollTo({
                            top: wrapper.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan saat memuat galeri:', error);
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    });
            }
        });
    </script>
@endpush
