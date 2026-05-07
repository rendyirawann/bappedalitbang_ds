@extends('frontend.layouts.app')

{{-- Judul Halaman yang dinamis berdasarkan Bidang --}}
@section('title',
    isset($bidangInfo)
    ? 'Kategori ' . $bidangInfo->bidang . ' - Bappedalitbang DS'
    : 'Berita Perencanaan
    - Bappedalitbang DS')

    @push('styles')
        <style>
            /* === Modernisasi Tampilan Berita === */

            /* 1. Membuat kartu berita yang melayang dan bersih */
            article.blog-card {
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 30px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                /* Bayangan sangat tipis */
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid #f1f1f1;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            /* 2. Efek saat kursor diarahkan ke kartu */
            article.blog-card:hover {
                transform: translateY(-8px);
                /* Melayang ke atas */
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                /* Bayangan lebih jelas */
            }

            /* 3. Menata gambar agar proporsional di dalam kartu */
            article.blog-card figure {
                margin: 0;
                overflow: hidden;
                position: relative;
                height: 220px;
                /* Tinggi gambar konsisten */
            }

            article.blog-card figure img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                /* Gambar mengisi ruang tanpa gepeng */
                transition: transform 0.5s ease;
            }

            article.blog-card:hover figure img {
                transform: scale(1.1);
                /* Gambar sedikit membesar */
            }

            /* 4. Menata teks konten kartu */
            article.blog-card .post_info {
                padding: 20px;
                flex-grow: 1;
                /* Konten mengisi sisa ruang */
                display: flex;
                flex-direction: column;
            }

            /* Tanggal */
            article.blog-card .post_info small {
                color: #999;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 8px;
                display: block;
            }

            /* Judul */
            article.blog-card .post_info h3 {
                font-weight: 700;
                font-size: 1.25rem;
                line-height: 1.4;
                margin-bottom: 12px;
            }

            article.blog-card .post_info h3 a {
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            article.blog-card .post_info h3 a:hover {
                color: #0056b3;
                /* Warna logo Bappeda */
            }

            /* Isi Ringkas */
            article.blog-card .post_info p {
                color: #666;
                font-size: 0.95rem;
                line-height: 1.6;
                margin-bottom: 20px;
                flex-grow: 1;
                /* Mendorong footer ke bawah */
            }

            /* 5. Bagian bawah kartu (Bidang & Tombol Baca) */
            article.blog-card .card-footer-custom {
                padding: 15px 20px;
                border-top: 1px solid #f1f1f1;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* Badge Bidang */
            .bidang-badge {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.85rem;
                color: #555;
            }

            /* Tombol 'Baca Selengkapnya' */
            .btn-baca {
                font-size: 0.85rem;
                font-weight: 600;
                padding: 6px 15px;
                border-radius: 20px;
                color: #fff;
                background: linear-gradient(to right, #002299, #0039ff);
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .btn-baca:hover {
                background-color: #004494;
            }

            /* === Modernisasi Sidebar === */
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

            /* List Berita Terbaru Modern */
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

            ul.latest-list-modern li h3 {
                font-size: 0.95rem;
                line-height: 1.4;
                margin: 0;
            }

            /* List Kategori Bidang Modern */
            ul.cats-modern {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            ul.cats-modern li {
                margin-bottom: 10px;
            }

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
                background: linear-gradient(to right, #002299, #0039ff);
                color: #fff;
            }

            ul.cats-modern li span {
                font-weight: 700;
                color: #999;
            }

            ul.cats-modern li a:hover span {
                color: rgba(255, 255, 255, 0.8);
            }
        </style>
    @endpush

@section('content')
    <section id="hero_in" class="general">
        <div class="wrapper">
            <div class="container">
                {{-- Judul Hero yang Dinamis --}}
                <h1 class="fadeInUp">
                    <span></span>
                    @if (isset($bidangInfo))
                        Kategori: {{ $bidangInfo->bidang }}
                    @else
                        Berita Perencanaan
                    @endif
                </h1>
            </div>
        </div>
    </section>
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-9">
                <div class="row g-4"> {{-- Gunakan Grid Bootstrap untuk kartu --}}
                    @forelse ($beritas as $berita)
                        <div class="col-md-6"> {{-- 2 Kartu per baris di Tablet ke atas --}}
                            <article class="blog-card wow fadeIn">
                                <figure>
                                    <a href="{{ route('berita.show', $berita->id) }}">
                                        @if ($berita->file)
                                            <img src="{{ asset('storage/uploads/berita/' . $berita->file) }}"
                                                alt="{{ $berita->judulBerita }}">
                                        @else
                                            {{-- Gambar Default jika berita tidak punya foto --}}
                                            <img src="{{ asset('udema/bappeda/default-berita.jpg') }}" alt="Default Image">
                                        @endif
                                    </a>
                                </figure>
                                <div class="post_info">
                                    {{-- Tanggal --}}
                                    <small>
                                        <i class="icon_clock_alt mr-1"></i>
                                        {{ $berita->tgl_berita ? $berita->tgl_berita->format('d M Y') : '' }}
                                    </small>

                                    {{-- Judul --}}
                                    <h3><a
                                            href="{{ route('berita.show', $berita->id) }}">{{ \Illuminate\Support\Str::limit($berita->judulBerita, 60, '...') }}</a>
                                    </h3>

                                    {{-- Isi Ringkas (Potong teks HTML agar bersih) --}}
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->isiBerita), 100, '...') }}</p>
                                </div>

                                {{-- Bagian Bawah Kartu --}}
                                <div class="card-footer-custom">
                                    {{-- Bidang (Responsive Fix seperti sebelumnya) --}}
                                    <div class="bidang-badge">
                                        <img src="{{ asset('udema/bappeda/bappeda.png') }}" alt="Logo"
                                            style="width: 24px; height: 24px; object-fit: contain;">
                                        <span>{{ $berita->bidang->bidang ?? 'Umum' }}</span>
                                    </div>

                                    {{-- Tombol Baca --}}
                                    <a href="{{ route('berita.show', $berita->id) }}" class="btn-baca">Baca</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 text-center w-100 mt-5">
                            <img src="{{ asset('udema/bappeda/no-data.png') }}" alt="No Data" width="120">
                            <p class="text-muted mt-3">Belum ada berita yang diterbitkan di kategori ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{-- Gunakan tampilan paginasi bootstrap-5 bawaan Laravel --}}
                    {{ $beritas->links('pagination::bootstrap-5') }}
                </div>
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
                                        {{ $latest->tgl_berita ? $latest->tgl_berita->format('d M') : '' }}
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
                            {{-- Tampilkan hanya jika ada berita di bidang tersebut --}}
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
