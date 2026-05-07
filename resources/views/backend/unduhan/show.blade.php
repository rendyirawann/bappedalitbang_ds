@extends('backend.layouts.app')

@section('title', 'Detail Berkas Unduhan')

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
                <li class="breadcrumb-item"><a href="{{ route('admin.unduhan.index') }}">Berkas Unduhan</a></li>
                <li class="breadcrumb-item active">Detail Kategori</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fa fa-folder-open"></i> Detail Kategori Unduhan</div>
                    <a href="{{ route('admin.unduhan.index') }}" class="btn btn-secondary btn-sm"><i
                            class="fa fa-arrow-left"></i>
                        Kembali ke Kategori</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%" class="bg-light">Nama Kategori / Folder</th>
                            <td>
                                <h5 class="m-0 font-weight-bold text-primary">{{ $unduhan->namaFile }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Dibuat Pada</th>
                            <td>{{ \Carbon\Carbon::parse($unduhan->created_at)->format('d M Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="m-0"><i class="fa fa-file-text-o"></i> Daftar File di Kategori Ini</h5>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahFile">
                            <i class="fa fa-plus"></i> Tambah Berkas File
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama File Fisik</th>
                                    <th width="20%">Waktu Upload</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ asset('storage/uploads/unduhan/' . $item->file) }}" target="_blank"
                                                style="text-decoration: none;">
                                                <span class="badge badge-info p-2">
                                                    <i class="fa fa-external-link mr-1"></i> {{ $item->file }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($item->tanggalUpload)
                                                {{ \Carbon\Carbon::parse($item->tanggalUpload)->format('d-m-Y H:i') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.unduhan-file.download', $item->id) }}"
                                                class="btn btn-success btn-sm" title="Download Berkas"><i
                                                    class="fa fa-download"></i></a>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modalEditFile{{ $item->id }}" title="Ganti File"><i
                                                    class="fa fa-edit"></i></button>

                                            <form action="{{ route('admin.unduhan-file.destroy', $item->id) }}"
                                                method="POST" class="form-hapus" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    title="Hapus File"><i class="fa fa-trash"></i></button>
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

    @foreach ($files as $item)
        <div class="modal fade" id="modalEditFile{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.unduhan-file.update', $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ganti File Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>File Saat Ini:</label>
                                <input type="text" class="form-control" value="{{ $item->file }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Upload File Baru Pengganti</label>
                                <input type="file" name="file" class="form-control-file" required>
                                <small class="text-muted d-block mt-1">Mendukung: PDF, DOCX, XLSX, ZIP, JPG, dll (Maks
                                    10MB).</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update File</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="modalTambahFile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.unduhan-file.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="refunduhan_id" value="{{ $unduhan->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Berkas ke: {{ $unduhan->namaFile }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih File Berkas (Bisa Lebih Dari 1)</label>
                            <input type="file" name="file_docs[]" class="form-control-file" required multiple>
                            <small class="text-muted d-block mt-2">Gunakan <b>CTRL</b> untuk memilih banyak file sekaligus.
                                Maks 10MB/file.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Mulai Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable();
            }

            $('form:not(.form-hapus)').on('submit', function() {
                $('#loading-overlay').show();
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error') || $errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') ?? 'Pastikan format file didukung (Maks 10MB)!' }}',
                });
            @endif

            // EVENT DELEGATION UNTUK HAPUS FILE
            $('#dataTable tbody').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "File fisik berkas ini akan dihapus secara permanen dari server!",
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
