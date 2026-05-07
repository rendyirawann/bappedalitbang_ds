@extends('frontend.layouts.app')

@section('title', 'Struktur Organisasi - Bappedalitbang Deli Serdang')

@push('styles')
    <link rel="stylesheet" href="{{ asset('udema/vendor/fancybox/fancybox.css') }}" />

    <style>
        /* === Desain Modern Struktur Organisasi === */
        .struktur-wrapper {
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f1f1;
            margin-bottom: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .struktur-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .struktur-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 3px solid #0056b3;
            display: inline-block;
            padding-bottom: 10px;
        }

        .struktur-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            cursor: zoom-in;
            border: 1px solid #eee;
            transition: transform 0.3s ease;
        }

        .struktur-image:hover {
            filter: brightness(0.95);
        }

        .zoom-hint {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #f8f9fa;
            border-radius: 20px;
            color: #555;
            font-size: 0.85rem;
            font-weight: 500;
        }
        /* === Deli Serdang Premium Org Chart Design === */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .org-chart-wrapper {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            padding: 60px 20px;
            overflow-x: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- Global Box Styles --- */
        .chart-box {
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .chart-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* --- Kaban (Top Header) --- */
        .box-kaban {
            background: linear-gradient(135deg, #002299 0%, #0039ff 100%);
            padding: 25px 40px;
            width: 320px;
        }

        .box-kaban h4 { color: #fff; margin: 0; font-weight: 700; letter-spacing: 1px; font-size: 18px; }
        .box-kaban p { color: rgba(255, 255, 255, 0.8); margin-top: 5px; font-size: 13px; font-weight: 400; }

        /* --- Sekretaris (Middle Header) --- */
        .box-sekre {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 20px 35px;
            width: 280px;
        }

        .box-sekre h4 { color: #fff; margin: 0; font-weight: 600; font-size: 16px; }
        .box-sekre p { color: rgba(255, 255, 255, 0.9); margin-top: 5px; font-size: 12px; }

        /* --- Kabid (Tier Boxes) --- */
        .kabid-row {
            display: flex;
            justify-content: center;
            gap: 25px;
            width: 100%;
            margin-top: 30px;
        }

        .box-kabid {
            background: #fff;
            padding: 20px;
            min-width: 200px;
            flex: 1;
            max-width: 240px;
            border-left: 5px solid #ccc; /* Will be colored below */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .box-kabid h4 { color: #1f2937; margin: 0; font-weight: 600; font-size: 14px; text-transform: uppercase; }
        
        /* --- Color Accents --- */
        .accent-green { border-left-color: #10b981; background: #ecfdf5; }
        .accent-blue { border-left-color: #3b82f6; background: #eff6ff; }
        .accent-yellow { border-left-color: #f59e0b; background: #fffbeb; }
        .accent-orange { border-left-color: #ef4444; background: #fef2f2; }

        /* --- Sub Boxes (Fungsional) --- */
        .box-sub {
            background: #fff;
            border: 1px solid #e5e7eb;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 15px;
            width: 100%;
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* --- Connector Lines (Vertical Trunk) --- */
        .trunk {
            width: 2px;
            background-color: #d1d5db;
            height: 40px;
            position: relative;
        }

        .horizontal-line {
            width: calc(100% - 220px);
            height: 2px;
            background-color: #d1d5db;
            position: relative;
        }

        /* --- Connecting Lines Details --- */
        .kabid-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .kabid-item::before {
            content: '';
            position: absolute;
            top: -30px;
            left: 50%;
            width: 2px;
            height: 30px;
            background-color: #d1d5db;
        }
    </style>
@endpush

@section('content')
    <section id="hero_in" class="general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>Struktur Organisasi</h1>
            </div>
        </div>
    </section>

    <div class="container margin_60_35">
        <div class="row justify-content-center">
            @php
                $hasValidData = $strukturs->isNotEmpty() && $strukturs->whereNotNull('file')->where('file', '!=', '')->count() > 0;
            @endphp

            @if ($hasValidData)
                @foreach ($strukturs as $key => $struktur)
                    @if($struktur->file)
                        <div class="col-lg-10 text-center">
                            <div class="struktur-wrapper wow fadeInUp" data-wow-delay="{{ $key * 0.1 }}s">
                                <h3 class="struktur-title">{{ $struktur->namaFile ?: 'Bagan Struktur Organisasi ' . ($key + 1) }}</h3>
                                <a href="{{ asset('storage/uploads/struktur/' . $struktur->file) }}"
                                    data-fancybox="struktur-gallery" data-caption="{{ $struktur->namaFile }}">
                                    <img src="{{ asset('storage/uploads/struktur/' . $struktur->file) }}"
                                        alt="{{ $struktur->namaFile }}" class="img-fluid struktur-image">
                                </a>
                                <div class="zoom-hint">
                                    <i class="bi bi-zoom-in me-1"></i> Klik gambar untuk memperbesar secara penuh
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="org-chart-wrapper wow fadeIn">
                        <!-- LEVEL 1: KABAN -->
                        <div class="chart-box box-kaban">
                            <h4>KEPALA BADAN</h4>
                            <p>Bappedalitbang Deli Serdang</p>
                        </div>
                        
                        <div class="trunk"></div>

                        <!-- LEVEL 2: SEKRETARIS -->
                        <div class="chart-box box-sekre">
                            <h4>SEKRETARIS</h4>
                            <p>Bappedalitbang Deli Serdang</p>
                        </div>
                        
                        <div class="trunk"></div>

                        <!-- LEVEL 2.5: KASUBAGS -->
                        <div class="horizontal-line" style="width: calc(100% - 450px);"></div>
                        <div class="kabid-row" style="margin-bottom: 0;">
                            <div class="kabid-item">
                                <div class="chart-box box-kabid" style="border-left-color: #9ca3af; background: #f3f4f6; min-width: 150px; padding: 12px;">
                                    <h4 style="font-size: 11px;">KASUBAG UMUM</h4>
                                </div>
                            </div>
                            <div class="kabid-item">
                                <div class="chart-box box-kabid" style="border-left-color: #9ca3af; background: #f3f4f6; min-width: 150px; padding: 12px;">
                                    <h4 style="font-size: 11px;">KASUBAG PROGRAM</h4>
                                </div>
                            </div>
                            <div class="kabid-item">
                                <div class="chart-box box-kabid" style="border-left-color: #9ca3af; background: #f3f4f6; min-width: 150px; padding: 12px;">
                                    <h4 style="font-size: 11px;">KASUBAG KEUANGAN</h4>
                                </div>
                            </div>
                        </div>

                        <div class="trunk" style="height: 60px;"></div>

                        <!-- LEVEL 3: KABIDS (HORIZONTAL ROW) -->
                        <div class="horizontal-line"></div>
                        
                        <div class="kabid-row">
                            <div class="kabid-item">
                                <div class="chart-box box-kabid accent-green">
                                    <h4>KABID PPEPD</h4>
                                    <div class="box-sub">JABATAN FUNGSIONAL</div>
                                </div>
                            </div>
                            <div class="kabid-item">
                                <div class="chart-box box-kabid accent-blue">
                                    <h4>KABID IDK</h4>
                                    <div class="box-sub">JABATAN FUNGSIONAL</div>
                                </div>
                            </div>
                            <div class="kabid-item">
                                <div class="chart-box box-kabid accent-yellow">
                                    <h4>KABID PPM</h4>
                                    <div class="box-sub">JABATAN FUNGSIONAL</div>
                                </div>
                            </div>
                            <div class="kabid-item">
                                <div class="chart-box box-kabid accent-orange">
                                    <h4>KABID LITBANG</h4>
                                    <div class="box-sub">JABATAN FUNGSIONAL</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <p class="text-center text-muted mt-5 font-italic">* Bagan dummy (Data resmi belum tersedia)</p> -->
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('udema/vendor/fancybox/fancybox.umd.js') }}"></script>
    <script>
        // Inisialisasi Fancybox 5 dengan fitur lengkap
        Fancybox.bind('[data-fancybox="struktur-gallery"]', {
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
    </script>
@endpush
