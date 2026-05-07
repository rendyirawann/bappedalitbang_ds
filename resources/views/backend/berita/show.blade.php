@extends('backend.layouts.app')
@section('title', 'Detail Berita Perencanaan')

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

        .alt-image-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background: #fff;
            transition: transform 0.2s;
        }

        .alt-image-box:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .alt-image-box img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div id="loading-overlay"></div>

    <div class="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Berita</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3>Detail Berita</h3>
                    </div>
                    <div>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        @if (in_array(auth()->user()->username, ['developer', 'admin', 'operator']))
                            <a href="{{ route('admin.berita.edit', $model->id) }}" class="btn btn-warning btn-sm"><i
                                    class="fa fa-edit"></i> Edit</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="20%" class="bg-light">Gambar Utama</th>
                            <td>
                                <img src="{{ asset('storage/uploads/berita/' . $model->file) }}" class="img-thumbnail"
                                    style="max-height: 250px;">
                                <br>
                                <a href="{{ route('admin.berita.download', $model->id) }}"
                                    class="btn btn-success btn-sm mt-2"><i class="fa fa-download"></i> Unduh Gambar
                                    Utama</a>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Judul Berita</th>
                            <td>
                                <h5>{{ strip_tags($model->judulBerita) }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Isi Berita</th>
                            <td>{!! $model->isiBerita !!}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Bidang</th>
                            <td>{{ $model->bidang->bidang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($model->tgl_berita)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td>
                                @if ($model->status == 0)
                                    <span class="badge badge-warning p-2"><i class="fa fa-hourglass-half"></i> Review</span>
                                @elseif($model->status == 1)
                                    <span class="badge badge-success p-2"><i class="fa fa-check"></i> Publish</span>
                                @else
                                    <span class="badge badge-danger p-2"><i class="fa fa-times-circle"></i> Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr class="my-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="m-0 font-weight-bold"><i class="fa fa-image"></i> Gambar Tambahan (Berita Alt)</h4>
                        @if (in_array(auth()->user()->username, ['developer', 'admin', 'operator']))
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahAlt">
                                <i class="fa fa-plus"></i> Tambah Gambar Berita
                            </button>
                        @endif
                    </div>

                    <div class="row">
                        @forelse ($model->beritaAlts ?? [] as $alt)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="alt-image-box">
                                    <a href="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}" target="_blank">
                                        <img src="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}"
                                            alt="Berita Alt">
                                    </a>

                                    <div class="d-flex justify-content-center mt-2">
                                        <a href="{{ route('admin.berita-alt.download', $alt->id) }}"
                                            class="btn btn-success btn-sm mr-2" title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>

                                        @if (in_array(auth()->user()->username, ['developer', 'admin', 'operator']))
                                            <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal"
                                                data-target="#modalEditAlt{{ $alt->id }}" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <form action="{{ route('admin.berita-alt.destroy', $alt->id) }}" method="POST"
                                                class="form-hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    Tidak ada Gambar Tambahan untuk Berita Perencanaan ini.
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

    @foreach ($model->beritaAlts ?? [] as $alt)
        <div class="modal fade" id="modalEditAlt{{ $alt->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.berita-alt.update', $alt->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ganti Gambar Tambahan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group text-center">
                                <img src="{{ asset('storage/uploads/berita_alt/' . $alt->file) }}" class="img-thumbnail"
                                    style="max-height: 150px;">
                            </div>
                            <div class="form-group mt-3">
                                <label>Ganti Gambar</label>
                                <input type="file" name="file" class="form-control-file" accept="image/*" required>
                                <small class="text-muted d-block mt-1">Silakan pilih gambar pengganti.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="modalTambahAlt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.berita-alt.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="berita_id" value="{{ $model->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Gambar Tambahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Upload Gambar (Bisa Lebih Dari 1)</label>
                            <input type="file" name="file_docs[]" class="form-control-file" required accept="image/*"
                                multiple>
                            <small class="text-muted d-block mt-2">Gunakan <b>CTRL</b> untuk memilih banyak gambar
                                sekaligus. Maks 5MB/gambar.</small>
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
            $('form:not(.form-hapus)').on('submit', function() {
                $('#loading-overlay').show();
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error') || $errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') ?? 'Pastikan format file benar (Maks 5MB)!' }}',
                });
            @endif

            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Gambar tambahan ini akan dihapus secara permanen!",
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
