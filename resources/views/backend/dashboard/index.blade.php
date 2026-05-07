@extends('backend.layouts.app')

@section('title', 'Dashboard | Bappedalitbang')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol>

            <div class="row">
                @if (session('success'))
                    <div class="col-12">
                        <div class="alert alert-success">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="col-12">
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    </div>
                @endif

                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card dashboard text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-book"></i>
                            </div>
                            <div class="mr-5">
                                <h5>{{ $countBeritaPerencanaan ?? 0 }} Berita Perencanaan</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ url('admin/berita') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card dashboard text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-book"></i>
                            </div>
                            <div class="mr-5">
                                <h5>{{ $countBeritaReview ?? 0 }} Berita Perlu di Review</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ url('admin/berita') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card dashboard text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-book"></i>
                            </div>
                            <div class="mr-5">
                                <h5>{{ $countBeritaPublish ?? 0 }} Berita Publish</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ url('admin/berita') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card dashboard text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-image"></i>
                            </div>
                            <div class="mr-5">
                                <h5>{{ $countGaleri ?? 0 }} Galeri Kegiatan</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ url('admin/galeri') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-bar-chart"></i> Data Berita Bidang
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100" height="30"></canvas>
                        </div>
                        <div class="card-footer small text-muted">Data Table</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var ctx = document.getElementById('myBarChart');
        if (ctx) {
            var myLineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($bidangLabels ?? ['PPEPD', 'Infrastruktur', 'Sosbud']),
                    datasets: [{
                        label: 'Jumlah Berita',
                        backgroundColor: 'rgba(2,117,216,1)',
                        borderColor: 'rgba(2,117,216,1)',
                        data: @json($bidangCounts ?? [10, 25, 15]),
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontSize: 10,
                                maxRotation: 45,
                                minRotation: 45,
                                autoSkip: false
                            },
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }
    </script>
@endpush
