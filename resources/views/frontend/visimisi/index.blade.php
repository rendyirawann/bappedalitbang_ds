@extends('frontend.layouts.app')

@section('title', 'Visi dan Misi - Bappedalitbang Deli Serdang')

@push('styles')
    <style>
        /* === Desain Visi Misi Baru: Dua Kolom Kontras === */
        .visi-misi-container {
            margin-top: 50px;
            margin-bottom: 80px;
        }

        /* Kotak Visi (Statement Besar & Mencolok) */
        /* Kotak Visi (Statement Besar & Mencolok) */
        .visi-box {
            /* INI YANG DIUBAH: */
            background: linear-gradient(to right, #002299, #0039ff);

            color: white;
            padding: 50px 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(72, 126, 201, 0.3);
            /* Bayangannya juga saya sesuaikan biar senada */
            height: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Elemen dekorasi air di belakang kotak visi */
        .visi-box::after {
            content: '\f10e';
            /* Ikon Quote FontAwesome */
            font-family: 'FontAwesome';
            position: absolute;
            font-size: 150px;
            color: rgba(255, 255, 255, 0.05);
            bottom: -20px;
            right: 10px;
            transform: rotate(-10deg);
            z-index: 0;
        }

        .visi-box .title-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            font-weight: 600;
            z-index: 1;
        }

        .visi-box .visi-text {
            font-size: 1.8rem;
            line-height: 1.5;
            font-weight: 700;
            z-index: 1;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Kotak Misi (Elegan & Rapi) */
        .misi-box {
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 15px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            border: 1px solid #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .misi-box .title-label {
            font-size: 1.8rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Garis aksen di sebelah judul Misi */
        .misi-box .title-label::before {
            content: '';
            display: inline-block;
            width: 40px;
            height: 4px;
            background-color: #0056b3;
            border-radius: 2px;
        }

        .misi-box .misi-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        /* Mempercantik tampilan list bawaan dari database */
        .misi-box .misi-text ul,
        .misi-box .misi-text ol {
            padding-left: 25px;
        }

        .misi-box .misi-text li {
            margin-bottom: 15px;
            padding-left: 10px;
        }

        .misi-box .misi-text li::marker {
            color: #0056b3;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <section id="hero_in" class="general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>Visi dan Misi</h1>
            </div>
        </div>
    </section>

    <div class="container visi-misi-container">
        @if ($visimisiData)
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5 wow fadeInLeft" data-wow-duration="1s">
                    <div class="visi-box">
                        <div class="title-label">
                            <i class="bi bi-eye me-2"></i>
                            {!! strip_tags($visimisiData->visiJudul) !!}
                        </div>
                        <div class="visi-text">
                            "{!! strip_tags($visimisiData->visiTeks) !!}"
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="misi-box">
                        <div class="title-label">
                            {!! strip_tags($visimisiData->misiJudul) !!}
                        </div>
                        <div class="misi-text">
                            {!! $visimisiData->misiTeks !!}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center mt-5">
                    <img src="{{ asset('udema/bappeda/no-data.png') }}" alt="No Data" width="120">
                    <p class="text-muted mt-3">Data Visi dan Misi belum tersedia.</p>
                </div>
            </div>
        @endif
    </div>
@endsection
