@extends('backend.layouts.app')

@section('title', 'Data Galeri Kegiatan')

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
                <li class="breadcrumb-item active">Galeri Kegiatan</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fa fa-table"></i> Data Galeri Kegiatan</div>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Keterangan / Nama File</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galeris as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->namaFile }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#modalShow{{ $item->id }}" title="Lihat Foto">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modalEdit{{ $item->id }}" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <a href="{{ route('admin.galeri.download', $item->id) }}"
                                                class="btn btn-success btn-sm" title="Download"><i
                                                    class="fa fa-download"></i></a>

                                            <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST"
                                                class="form-hapus" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    title="Hapus"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    @include('backend.galeri.show', ['item' => $item])
                                    @include('backend.galeri.edit', ['item' => $item])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Data Tabel Galeri</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Galeri Kegiatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama / Keterangan Galeri</label>
                            <input type="text" name="namaFile" class="form-control" required
                                placeholder="Masukkan keterangan...">
                        </div>
                        <div class="form-group">
                            <label>Upload Gambar (Bisa Lebih Dari 1)</label>
                            <input type="file" name="file_docs[]" class="form-control-file" required accept="image/*"
                                multiple>
                            <small class="text-muted">Gunakan tombol <b>CTRL</b> atau usap kursor untuk memilih banyak
                                gambar sekaligus. Maks 5MB/gambar.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                    text: '{{ session('error') ?? 'Pastikan semua kolom diisi dan format file benar!' }}',
                });
            @endif

            $('#dataTable tbody').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Gambar ini akan dihapus secara permanen!",
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
