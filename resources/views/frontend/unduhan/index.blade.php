@extends('frontend.layouts.app')

@section('title', 'Pusat Unduhan - Bappedalitbang Deli Serdang')

@push('styles')
    <link rel="stylesheet" href="{{ asset('udema/vendor/fancybox/fancybox.css') }}" />
    <style>
        /* === Desain Profil Dipercantik: Modern Image Card === */
        .profil-card-modern {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            background: #fff;
            transition: all 0.4s ease;
            cursor: zoom-in;
        }

        .profil-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 86, 179, 0.15);
        }

        .profil-img-wrapper {
            position: relative;
            width: 100%;
            height: 250px;
            /* Tinggi gambar dibuat pas */
            overflow: hidden;
        }

        .profil-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* Efek gambar membesar saat kursor diarahkan */
        .profil-card-modern:hover .profil-img-wrapper img {
            transform: scale(1.1);
        }

        /* Gradasi gelap di bawah agar teks putih terbaca jelas */
        .profil-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 25px 20px 20px;
            pointer-events: none;
            /* Agar klik tetap tembus ke gambar */
        }

        .profil-overlay h4 {
            color: #ffffff;
            margin: 0 0 5px 0;
            font-size: 1.15rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        .profil-overlay small {
            color: #d1e4ff;
            font-size: 0.85rem;
        }

        /* Ikon mata melayang di pojok kanan atas */
        .profil-action-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: #0056b3;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .profil-card-modern:hover .profil-action-btn {
            opacity: 1;
            transform: scale(1);
        }

        /* === Desain Document Center (Tetap Paten) === */
        .document-wrapper {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
            border: 1px solid #f8f9fa;
            padding: 30px;
            margin-bottom: 50px;
        }

        .doc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .doc-header h3 {
            margin: 0;
            font-weight: 700;
            color: #333;
            font-size: 1.4rem;
        }

        .search-box {
            position: relative;
            min-width: 300px;
        }

        .search-box input {
            padding: 10px 15px 10px 40px;
            border-radius: 30px;
            border: 1px solid #ddd;
            width: 100%;
            transition: all 0.3s;
        }

        .search-box input:focus {
            border-color: #0056b3;
            outline: none;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .bidang-category-header {
            background-color: #f8f9fa;
            padding: 12px 20px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .bidang-category-header h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
        }

        .doc-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .doc-item:hover {
            background: #fafafa;
            border-color: #ccc;
        }

        .doc-icon {
            font-size: 2rem;
            color: #dc3545;
            margin-right: 20px;
        }

        .doc-info {
            flex-grow: 1;
        }

        .doc-info h5 {
            margin: 0 0 5px 0;
            font-size: 1.05rem;
            font-weight: 600;
            color: #222;
        }

        .badge-kategori {
            background-color: #e9ecef;
            color: #555;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 15px;
        }

        .doc-action .btn-download {
            background: linear-gradient(to right, #002299, #0039ff);
            color: #fff;
            border-radius: 20px;
            padding: 6px 18px;
            font-size: 0.85rem;
            transition: background 0.3s;
        }

        .doc-action .btn-download:hover {
            background-color: #003d82;
        }

        @media (max-width: 768px) {
            .doc-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .doc-icon {
                margin-bottom: 10px;
            }

            .doc-action {
                margin-top: 15px;
                width: 100%;
            }

            .doc-action .btn-download {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <section id="hero_in" class="general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>Pusat Unduhan</h1>
            </div>
        </div>
    </section>

    <div class="container margin_60_35">

        <div class="main_title_2 mb-4">
            <span><em></em></span>
            <h2>Profil Bappedalitbang</h2>
            <p>Dokumen Profil Terkini</p>
        </div>

        <div class="row mb-5 justify-content-center">
            @forelse ($profils as $key => $profil)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $key * 0.1 }}s">
                    <a href="{{ asset('storage/uploads/profil/' . $profil->file) }}" data-fancybox="profil-gallery"
                        data-caption="{{ $profil->namaFile ?? 'Profil' }}" class="d-block text-decoration-none">

                        <div class="profil-card-modern">
                            <div class="profil-img-wrapper">
                                <img src="{{ asset('storage/uploads/profil/' . $profil->file) }}" alt="Profil">
                            </div>

                            <div class="profil-action-btn">
                                <i class="bi bi-eye-fill"></i>
                            </div>

                            <div class="profil-overlay">
                                <h4>{{ $profil->namaFile ?? 'Dokumen Profil' }}</h4>
                                <small>
                                    <i class="bi bi-calendar-check me-1"></i>
                                    Diperbarui:
                                    {{ $profil->tanggalUpload ? \Carbon\Carbon::parse($profil->tanggalUpload)->translatedFormat('d F Y') : '-' }}
                                </small>
                            </div>
                        </div>

                    </a>
                </div>
            @empty
                <p class="text-center text-muted w-100">Belum ada file profil.</p>
            @endforelse
        </div>

        <div class="document-wrapper wow fadeInUp" data-wow-delay="0.2s">
            <div class="doc-header">
                <h3><i class="bi bi-folder2-open me-2 text-primary"></i> Dokumen & Berkas Publik</h3>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari berkas atau bidang..."
                        value="{{ request('search') }}">
                </div>
            </div>

            <div id="ajax-document-container" style="transition: opacity 0.3s ease;">

                @if ($unduhanFiles->count() > 0)
                    @php
                        // Mengelompokkan data yang tampil di halaman ini berdasarkan nama Bidang
                        $groupedFiles = $unduhanFiles->groupBy(function ($item) {
                            return $item->unduhan->bidang->bidang ?? 'Umum';
                        });
                    @endphp

                    @foreach ($groupedFiles as $bidangName => $files)
                        <div class="bidang-category-header">
                            <h4><i class="bi bi-grid-1x2-fill me-2 text-success"></i> Bidang: {{ $bidangName }}</h4>
                        </div>

                        @foreach ($files as $file)
                            <div class="doc-item">
                                <div class="doc-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                                <div class="doc-info">
                                    <h5>{{ $file->file }}</h5>
                                    <div class="mb-1">
                                        <span class="badge-kategori"><i class="bi bi-tag"></i>
                                            {{ $file->unduhan->namaFile ?? 'Dokumen' }}</span>
                                    </div>
                                    <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>
                                        {{ $file->tanggalUpload ? \Carbon\Carbon::parse($file->tanggalUpload)->format('d/m/Y') : '-' }}</small>
                                </div>
                                <div class="doc-action">
                                    <a href="{{ asset('storage/uploads/unduhan/' . $file->file) }}" target="_blank"
                                        class="btn-download d-inline-block">
                                        <i class="bi bi-download me-1"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <img src="{{ asset('udema/bappeda/no-data.png') }}" alt="No Data" width="100">
                        <h5 class="mt-3 text-muted">Berkas tidak ditemukan.</h5>
                        <p class="text-muted">Coba gunakan kata kunci pencarian yang lain.</p>
                    </div>
                @endif

                @if ($unduhanFiles->hasPages())
                    <div
                        class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top flex-column flex-md-row">
                        <div class="text-muted small mb-3 mb-md-0 fw-medium">
                            Menampilkan {{ $unduhanFiles->firstItem() ?? 0 }} sampai
                            {{ $unduhanFiles->lastItem() ?? 0 }} dari {{ $unduhanFiles->total() }} berkas
                        </div>
                        <div>
                            {{ $unduhanFiles->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('udema/vendor/fancybox/fancybox.umd.js') }}"></script>
    <script>
        Fancybox.bind('[data-fancybox="profil-gallery"]', {
            animated: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            let container = document.getElementById('ajax-document-container');
            let searchInput = document.getElementById('searchInput');
            let timeout = null;

            searchInput.addEventListener('input', function(e) {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    let url = new URL(window.location.href);
                    if (e.target.value === '') {
                        url.searchParams.delete('search');
                    } else {
                        url.searchParams.set('search', e.target.value);
                    }
                    url.searchParams.delete('page');
                    fetchData(url.toString());
                }, 500);
            });

            document.body.addEventListener('click', function(e) {
                let pageLink = e.target.closest('.pagination a');
                if (pageLink) {
                    e.preventDefault();
                    fetchData(pageLink.href);
                    window.scrollTo({
                        top: document.querySelector('.document-wrapper').offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });

            function fetchData(url) {
                container.style.opacity = '0.3';
                container.style.pointerEvents = 'none';

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');

                        let newContent = doc.getElementById('ajax-document-container').innerHTML;
                        container.innerHTML = newContent;

                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                        window.history.pushState({}, '', url);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    });
            }
        });
    </script>
@endpush
