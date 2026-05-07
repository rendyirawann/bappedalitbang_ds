@extends('frontend.layouts.app')

@section('title', $berita->judulBerita)

@section('content')
<section id="hero_in" class="general">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span>Baca Berita Perencanaan</h1>
        </div>
    </div>
</section>

<div class="container margin_60_35">
    <div class="row">
        <div class="col-lg-9">
            <div class="bloglist singlepost">
                <p><img alt="" class="img-fluid rounded"
                        src="{{ asset('storage/uploads/berita/' . $berita->file) }}"
                        style="max-height: 500px; width: 100%; object-fit: cover;"></p>
                <h1>{{ $berita->judulBerita }}</h1>
                <div class="postmeta">
                    <ul>
                        <li><a href="{{ route('berita.bidang', $berita->bidang_id) }}"><i class="icon_folder-alt"></i>
                                {{ $berita->bidang->bidang ?? 'Umum' }}</a></li>
                        <li><a href="#"><i class="icon_clock_alt"></i>
                                {{ $berita->tgl_berita ? $berita->tgl_berita->format('d F Y') : '' }}</a></li>
                    </ul>
                </div>

                <div class="post-content mt-4">
                    {!! $berita->isiBerita !!}
                </div>
            </div>

            @if ($berita->beritaAlts->count() > 0)
            <div class="mt-5 mb-5">
                <h4 class="mb-3">Dokumentasi Tambahan</h4>
                <div id="carouselBeritaAlt" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow-sm">
                        @foreach ($berita->beritaAlts as $index => $alt)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}"
                                class="d-block w-100" alt="Gambar Tambahan"
                                style="max-height: 500px; object-fit: cover;">
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
            <hr>
            <p class="text-muted fst-italic">Berita tidak memiliki gambar kegiatan lain.</p>
            @endif
        </div>

        <aside class="col-lg-3">
            <div class="widget">
                <div class="widget-title">
                    <h4>Berita Terbaru</h4>
                </div>
                <ul class="comments-list">
                    @foreach ($latestBerita as $latest)
                    <li>
                        <div class="alignleft">
                            <a href="{{ route('berita.show', $latest->id) }}">
                                <img src="{{ asset('storage/uploads/berita/' . $latest->file) }}" alt=""
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </a>
                        </div>
                        <small>{{ $latest->tgl_berita ? $latest->tgl_berita->format('d M Y') : '' }}</small>
                        <h3><a href="{{ route('berita.show', $latest->id) }}"
                                title="">{{ \Illuminate\Support\Str::limit(strip_tags($latest->judulBerita), 40, '...') }}</a>
                        </h3>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="widget">
                <div class="widget-title">
                    <h4>Kategori Bidang Berita</h4>
                </div>
                <ul class="cats">
                    @foreach ($kategoriBidang as $bidang)
                    <li>
                        <i class="fa fa-folder-open-o"></i>
                        <a href="{{ route('berita.bidang', $bidang->id) }}">
                            {{ $bidang->bidang }} <span>({{ $bidang->beritas_count }})</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection