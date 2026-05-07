@extends('frontend.layouts.app')

@section('title', isset($bidangInfo) ? 'Berita Bidang ' . $bidangInfo->bidang : 'Berita Perencanaan')

@push('styles')
<style>
    /* CSS Paginasi bawaan Yii2 yang dipertahankan */
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }

    .pagination>li {
        display: inline;
    }

    .pagination>li>a,
    .pagination>li>span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }

    .pagination>li:first-child>a,
    .pagination>li:first-child>span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .pagination>li:last-child>a,
    .pagination>li:last-child>span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .pagination>li>a:hover,
    .pagination>li>span:hover,
    .pagination>li>a:focus,
    .pagination>li>span:focus {
        color: #23527c;
        background-color: #eee;
        border-color: #ddd;
    }

    .pagination>.active>a,
    .pagination>.active>span,
    .pagination>.active>a:hover,
    .pagination>.active>span:hover,
    .pagination>.active>a:focus,
    .pagination>.active>span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }
</style>
@endpush

@section('content')
<section id="hero_in" class="general">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp">
                <span></span>{{ isset($bidangInfo) ? 'Berita Bidang ' . $bidangInfo->bidang : 'Berita Perencanaan' }}
            </h1>
        </div>
    </div>
</section>

<div class="container margin_60_35">
    <div class="row">
        <div class="col-lg-9">
            @forelse ($beritas as $berita)
            <article class="blog wow fadeIn">
                <div class="row g-0">
                    <div class="col-lg-7">
                        <figure>
                            <a href="{{ route('berita.show', $berita->id) }}">
                                <img src="{{ asset('storage/uploads/berita/' . $berita->file) }}" alt=""
                                    style="max-width: 400px; max-height: 200px; object-fit: cover;">
                                <div class="preview"><span>Baca Lebih Lanjut</span></div>
                            </a>
                        </figure>
                    </div>
                    <div class="col-lg-5">
                        <div class="post_info">
                            <small>{{ $berita->tgl_berita ? $berita->tgl_berita->format('d M Y') : '' }}</small>
                            <h3><a href="{{ route('berita.show', $berita->id) }}">{{ $berita->judulBerita }}</a>
                            </h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->isiBerita), 120, '...') }}</p>
                            <ul>
                                <li style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset('udema/bappeda/bappeda.png') }}" alt="Logo Bappeda"
                                        style="width: 30px; height: 30px; object-fit: contain; border-radius: 50%; background-color: white;">
                                    <span>{{ $berita->bidang->bidang ?? 'Umum' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="alert alert-info">Belum ada berita di kategori ini.</div>
            @endforelse

            <div class="d-flex justify-content-center mt-4">
                {{ $beritas->links('pagination::bootstrap-4') }}
            </div>
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