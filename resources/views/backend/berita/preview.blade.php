@extends('backend.layouts.app-front')

{{-- Judul halaman adalah judul beritanya --}}
@section('title', strip_tags($berita->judulBerita) . ' - Preview Bappedalitbang DS')

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

        /* Meta Info (Tanggal & Kategori) */
        .singlepost .postmeta {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .singlepost .postmeta ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
        }

        .singlepost .postmeta ul li {
            font-size: 0.9rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .singlepost .postmeta ul li i {
            color: #007bff;
        }

        /* Konten Paragraf */
        .post-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #444;
        }

        .post-content p {
            margin-bottom: 20px;
            text-align: justify;
        }

        /* Gambar Tambahan (Berita Alt) */
        .alt-image-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .alt-image-card:hover {
            transform: translateY(-5px);
        }

        .alt-image-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .alt-image-caption {
            background: #f8f9fa;
            padding: 10px 15px;
            font-size: 0.85rem;
            color: #555;
            text-align: center;
            border-top: 1px solid #eee;
        }

        /* === Sidebar Modernisasi === */
        .widget-modern {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f1f1;
            margin-bottom: 30px;
        }

        .widget-title-modern {
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
            margin-bottom: 20px;
            position: relative;
        }

        .widget-title-modern h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
            color: #222;
        }

        .widget-title-modern::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: #007bff;
        }

        /* List Berita Terbaru */
        .comments-list-modern {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .comments-list-modern li {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: flex-start;
        }

        .comments-list-modern li:last-child {
            margin-bottom: 0;
        }

        .comments-list-modern li .img-wrapper {
            flex-shrink: 0;
            width: 70px;
            height: 70px;
            border-radius: 8px;
            overflow: hidden;
        }

        .comments-list-modern li .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comments-list-modern li .desc-wrapper {
            flex-grow: 1;
        }

        .comments-list-modern li .desc-wrapper small {
            display: block;
            font-size: 0.75rem;
            color: #888;
            margin-bottom: 5px;
        }

        .comments-list-modern li .desc-wrapper h3 {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            margin: 0;
        }

        .comments-list-modern li .desc-wrapper h3 a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .comments-list-modern li .desc-wrapper h3 a:hover {
            color: #007bff;
        }

        /* List Kategori */
        .cats-modern {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cats-modern li {
            margin-bottom: 10px;
        }

        .cats-modern li:last-child {
            margin-bottom: 0;
        }

        .cats-modern li a {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            color: #555;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .cats-modern li a:hover {
            background: #007bff;
            color: #fff;
        }

        /* Sticky Button Alert */
        .admin-alert-bar {
            background-color: #ffc107;
            color: #000;
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
    </style>
@endpush

@section('content')
    <div class="admin-alert-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <span><i class="fa fa-eye"></i> Anda sedang berada dalam Mode Preview (Pratinjau)</span>
            <a href="{{ url('admin/berita') }}" class="btn btn-dark btn-sm"><i class="fa fa-arrow-left"></i> Kembali ke Panel
                Admin</a>
        </div>
    </div>

    <div class="container margin_60_35 mt-4">
        <div class="row">
            {{-- Bagian Kiri: Konten Utama --}}
            <div class="col-lg-9" id="preview">
                <div class="singlepost">
                    {{-- Gambar Utama Berita --}}
                    <p>
                        <img alt="{{ strip_tags($berita->judulBerita) }}" class="main-news-img"
                            src="{{ asset('storage/uploads/berita/' . $berita->file) }}">
                    </p>

                    {{-- Judul Berita --}}
                    <h1>{{ strip_tags($berita->judulBerita) }}</h1>

                    {{-- Metadata Berita --}}
                    <div class="postmeta">
                        <ul>
                            <li><i class="fa fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($berita->tgl_berita)->translatedFormat('d F Y') }}</li>
                            <li><i class="fa fa-folder"></i> {{ $berita->bidang->bidang ?? 'Umum' }}</li>
                            <li><i class="fa fa-user"></i> Admin</li>
                        </ul>
                    </div>

                    {{-- Isi Berita (Dirender sebagai HTML) --}}
                    <div class="post-content mt-4">
                        {!! $berita->isiBerita !!}
                    </div>

                    {{-- Render BeritaAlt images (Jika nanti modulnya sudah disambungkan) --}}
                    {{-- @if ($berita->beritaAlts && $berita->beritaAlts->count() > 0)
                        <hr class="mt-5 mb-4">
                        <h4 class="mb-4 font-weight-bold">Galeri Kegiatan Terkait</h4>
                        <div class="row">
                            @foreach ($berita->beritaAlts as $alt)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}" data-lightbox="berita-gallery" data-title="{{ $alt->keterangan }}">
                                        <div class="alt-image-card">
                                            <img src="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}" alt="Berita Image">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif --}}
                </div>
            </div>

            {{-- Bagian Kanan: Sidebar --}}
            <aside class="col-lg-3">
                {{-- Widget Berita Terbaru --}}
                <div class="widget-modern">
                    <div class="widget-title-modern">
                        <h4>Berita Terbaru</h4>
                    </div>
                    <ul class="comments-list-modern">
                        @foreach ($latestBeritas as $latest)
                            <li>
                                <div class="img-wrapper">
                                    <a href="#">
                                        <img src="{{ asset('storage/uploads/berita/' . $latest->file) }}"
                                            alt="{{ strip_tags($latest->judulBerita) }}">
                                    </a>
                                </div>
                                <div class="desc-wrapper">
                                    <small><i class="fa fa-clock-o"></i>
                                        {{ \Carbon\Carbon::parse($latest->tgl_berita)->translatedFormat('d M Y') }}</small>
                                    <h3>
                                        <a href="#" title="{{ $latest->judulBerita }}">
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
                                    <a href="#">
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
