@extends('backend.layouts.app')
@section('title', 'Data Berita Perencanaan')

@push('styles')
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 99999;
            backdrop-filter: blur(3px);
        }

        #loading-overlay:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50px;
            height: 50px;
            margin-top: -25px;
            margin-left: -25px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div id="loading-overlay"></div>
    <div class="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Berita Perencanaan</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fa fa-table"></i> Data Berita Perencanaan</div>
                    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        Tambah
                        Berita</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Judul Berita</th>
                                    <th>Bidang</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Status</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($beritas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::limit(strip_tags($item->judulBerita), 60) }}</td>
                                        <td>{{ $item->bidang->bidang ?? 'Umum' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tgl_berita)->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            @if ($item->status == 0)
                                                <span class="badge badge-warning p-2"><i class="fa fa-hourglass-half"></i>
                                                    Review</span>
                                            @elseif($item->status == 1)
                                                <span class="badge badge-success p-2"><i class="fa fa-check"></i>
                                                    Publish</span>
                                            @else
                                                <span class="badge badge-danger p-2"><i class="fa fa-times-circle"></i>
                                                    Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/berita/' . $item->id . '/preview') }}" target="_blank"
                                                class="btn btn-secondary btn-sm" title="Preview Frontend">
                                                <i class="fa fa-globe"></i>
                                            </a>

                                            <a href="{{ url('admin/berita/' . $item->id) }}" class="btn btn-info btn-sm"
                                                title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a href="{{ url('admin/berita/' . $item->id . '/edit') }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ url('admin/berita/' . $item->id) }}" method="POST"
                                                class="form-hapus" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable();
            }

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            $('#dataTable tbody').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus Berita?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loading-overlay').show();
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
