@extends('backend.layouts.app')

@section('title', 'Manajemen Pegawai')

@section('content')
    <style>
        /* Fix for invisible dropdowns in SelectBox */
        .sbOptions {
            background-color: #fff !important;
            border: 1px solid #ccc !important;
            z-index: 9999 !important;
        }

        .sbOptions a {
            color: #333 !important;
            display: block !important;
            padding: 5px 10px !important;
            text-decoration: none !important;
        }

        .sbOptions a:hover {
            background-color: #007bff !important;
            color: #fff !important;
        }

        .sbHolder {
            width: 100% !important;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manajemen Pegawai</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fa fa-vcard"></i> Data Pegawai</div>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Pegawai
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIP</th>
                                    <th>Aparatur</th>
                                    <th>Bidang</th>
                                    <th>Eselon</th>
                                    <th>Jabatan (Title)</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawais as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->namaLengkap }}</td>
                                        <td>{{ $p->nip ?? '-' }}</td>
                                        <td>{{ $p->statusAparatur == 1 ? 'ASN' : 'Non-ASN' }}</td>
                                        <td>{{ $p->bidang->bidang ?? '-' }}</td>
                                        <td>{{ $p->pegawaiEselon->nm_eselon ?? '-' }}</td>
                                        <td>{{ $p->title->title ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#modalShow{{ $p->id }}" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modalEdit{{ $p->id }}" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.pegawai.destroy', $p->id) }}" method="POST"
                                                class="d-inline form-hapus">
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

            {{-- Pecahan Modal Show & Edit diletakkan di luar tabel agar tidak merusak layout --}}
            @foreach ($pegawais as $p)
                @include('backend.pegawai.show', ['p' => $p])
                @include('backend.pegawai.edit', [
                    'p' => $p,
                    'bidangs' => $bidangs,
                    'eselons' => $eselons,
                    'titles' => $titles,
                ])
            @endforeach
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('admin.pegawai.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="namaLengkap" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status Aparatur</label>
                                    <select name="statusAparatur" class="form-control" required>
                                        <option value="1">ASN</option>
                                        <option value="2">Non-ASN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bidang</label>
                                    <select name="kodeBidang" class="form-control">
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach ($bidangs as $b)
                                            <option value="{{ $b->id }}">{{ $b->bidang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Eselon</label>
                                    <select name="eselon" class="form-control">
                                        <option value="">-- Pilih Eselon --</option>
                                        @foreach ($eselons as $e)
                                            <option value="{{ $e->id }}">{{ $e->nm_eselon }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan (Title)</label>
                                    <select name="kodeTitle" class="form-control">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($titles as $t)
                                            <option value="{{ $t->id }}">{{ $t->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" name="no_hp" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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

            @if (session('success'))
                Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
            @endif

            // --- AJAX FORM SUBMISSION ---
            $('form:not(.form-hapus)').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method');
                let formData = form.serialize();

                // Clear previous errors
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                let input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + value[0] +
                                    '</div>');
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Mohon periksa kembali form Anda.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan sistem.',
                            });
                        }
                    }
                });
            });

            $('.btn-delete').on('click', function() {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus data pegawai ini?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endpush
