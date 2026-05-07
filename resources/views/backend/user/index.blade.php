@extends('backend.layouts.app')

@section('title', 'Manajemen User')

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
                <li class="breadcrumb-item active">Manajemen User</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fa fa-users"></i> Data User</div>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah User
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Bidang</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->bidang->bidang ?? '-' }}</td>
                                        <td>
                                            @if ($user->status == 10)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#modalShow{{ $user->id }}" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modalEdit{{ $user->id }}" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            @if ($user->username !== 'developer')
                                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                                    class="d-inline form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pecahan Modal Show & Edit diletakkan di luar tabel agar tidak merusak layout --}}
            @foreach ($users as $user)
                @include('backend.user.show', ['user' => $user])
                @include('backend.user.edit', ['user' => $user, 'bidangs' => $bidangs])
            @endforeach
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Bidang</label>
                            <select name="bidang_id" class="form-control">
                                <option value="">-- Tanpa Bidang --</option>
                                @foreach ($bidangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->bidang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="10">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
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

            @if (session('error'))
                Swal.fire('Error!', '{{ session('error') }}', 'error');
            @endif

            $('.btn-delete').on('click', function() {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus user ini?',
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
