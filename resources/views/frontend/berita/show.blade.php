@extends('frontend.layouts.app')

{{-- Judul halaman adalah judul beritanya --}}
@section('title', $berita->judulBerita . ' - Bappedalitbang DS')

@push('styles')
    <style>
        /* === Modernisasi Halaman Detail === */
        .singlepost {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f1f1;
            margin-bottom: 30px;
        }

        /* Gambar Utama */
        .singlepost p img.main-news-img {
            max-height: 500px;
            width: 100%;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Judul Besar */
        .singlepost h1 {
            font-weight: 800;
            font-size: 2.5rem;
            line-height: 1.2;
            margin-top: 25px;
            margin-bottom: 15px;
            color: #111;
        }

        /* Meta Info (Bidang & Tanggal) */
        .postmeta-modern {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
            font-size: 0.9rem;
            color: #888;
        }

        .postmeta-modern a {
            color: #888;
            text-decoration: none;
        }

        .postmeta-modern a:hover {
            color: #0056b3;
        }

        .postmeta-modern i {
            margin-right: 5px;
            color: #0056b3;
        }

        /* Konten Artikel */
        .post-content-modern {
            font-size: 1.1rem;
            /* Ukuran teks dinaikkan agar nyaman dibaca */
            line-height: 1.8;
            /* Jarak antar baris lebih longgar */
            color: #444;
        }

        .post-content-modern p {
            margin-bottom: 20px;
        }

        /* === Modernisasi Carousel === */
        .documentation-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f1f1;
        }

        .carousel-inner-modern img {
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* === Gaya Sidebar Modern (Sama seperti index) === */
        .widget-modern {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f1f1;
        }

        .widget-title-modern {
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .widget-title-modern h4 {
            margin: 0;
            font-weight: 700;
            color: #333;
        }

        ul.latest-list-modern {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul.latest-list-modern li {
            margin-bottom: 15px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        ul.latest-list-modern li img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        /* === TAMBAHKAN KODE INI DI SINI === */
        ul.latest-list-modern li h3 {
            font-size: 0.95rem;
            line-height: 1.4;
            margin: 0;
            font-weight: 600;
        }

        /* ================================= */

        ul.cats-modern li a {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
            background-color: #f9f9f9;
            border-radius: 8px;
            text-decoration: none;
            color: #555;
            transition: all 0.3s ease;
        }

        ul.cats-modern li a:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <section id="hero_in" class="general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>Detail Berita Perencanaan</h1>
            </div>
        </div>
    </section>
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-9">
                <div class="singlepost wow fadeIn">
                    {{-- Gambar Utama --}}
                    @if ($berita->file)
                        <p><img alt="{{ $berita->judulBerita }}" class="img-fluid main-news-img"
                                src="{{ asset('storage/uploads/berita/' . $berita->file) }}"></p>
                    @endif

                    {{-- Judul Besar --}}
                    <h1>{{ $berita->judulBerita }}</h1>

                    {{-- Meta Info Modern --}}
                    <div class="postmeta-modern">
                        {{-- Bidang --}}
                        <span>
                            <a href="{{ route('berita.bidang', $berita->bidang_id) }}">
                                <i class="icon_folder-alt"></i> {{ $berita->bidang->bidang ?? 'Umum' }}
                            </a>
                        </span>
                        {{-- Tanggal --}}
                        <span>
                            <i class="icon_clock_alt"></i>
                            {{ $berita->tgl_berita ? $berita->tgl_berita->translatedFormat('d F Y') : '' }}
                        </span>
                    </div>

                    {{-- Konten Artikel yang nyaman dibaca --}}
                    <div class="post-content-modern mt-4">
                        {!! $berita->isiBerita !!}
                    </div>
                </div>

                @if ($berita->beritaAlts->count() > 0)
                    <div class="documentation-section mt-5 mb-5 wow fadeIn">
                        <h4 class="mb-4 font-weight-bold">Dokumentasi Tambahan</h4>
                        <div id="carouselBeritaAlt" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner carousel-inner-modern">
                                @foreach ($berita->beritaAlts as $index => $alt)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}"
                                            class="d-block w-100" alt="Gambar Tambahan">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselBeritaAlt"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselBeritaAlt"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                @else
                    <hr class="wow fadeIn">
                    <p class="text-muted fst-italic wow fadeIn">Berita ini tidak memiliki dokumentasi gambar kegiatan
                        lainnya.</p>
                @endif
            </div>

            <aside class="col-lg-3">
                {{-- Widget Berita Terbaru --}}
                <div class="widget-modern">
                    <div class="widget-title-modern">
                        <h4>Berita Terbaru</h4>
                    </div>
                    <ul class="latest-list-modern">
                        @foreach ($latestBerita as $latest)
                            <li>
                                @if ($latest->file)
                                    <img src="{{ asset('storage/uploads/berita/' . $latest->file) }}" alt="">
                                @else
                                    <img src="{{ asset('udema/bappeda/default-berita.jpg') }}" alt="Default">
                                @endif
                                <div>
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        {{ $latest->tgl_berita ? $latest->tgl_berita->format('d M Y') : '' }}
                                    </small>
                                    <h3>
                                        <a href="{{ route('berita.show', $latest->id) }}"
                                            title="{{ $latest->judulBerita }}" style="color:#333; text-decoration:none;">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($latest->judulBerita), 35, '...') }}
                                        </a>
                                    </h3>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Widget Kategori Bidang --}}
                <div class="widget-modern">
                    <div class="widget-title-modern">
                        <h4>Kategori Bidang</h4>
                    </div>
                    <ul class="cats-modern">
                        @foreach ($kategoriBidang as $bidang)
                            @if ($bidang->beritas_count > 0)
                                <li>
                                    <a href="{{ route('berita.bidang', $bidang->id) }}">
                                        <span>{{ $bidang->bidang }}</span>
                                        <span>{{ $bidang->beritas_count }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
@endsection
