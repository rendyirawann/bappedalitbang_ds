@extends('backend.layouts.app')

@section('title', 'Ganti Password')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Ganti Password</li>
            </ol>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-key"></i> Form Ganti Password
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('admin.change-auth.update') }}" method="POST">
                                @csrf
                                <div class="form-group position-relative">
                                    <label>Password Lama</label>
                                    <input type="password" name="old_password" id="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror" required>
                                    <span class="toggle-password" onclick="togglePassword('old_password')">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group position-relative">
                                    <label>Password Baru</label>
                                    <input type="password" name="new_password" id="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror" required>
                                    <span class="toggle-password" onclick="togglePassword('new_password')">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group position-relative">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="form-control" required>
                                    <span class="toggle-password" onclick="togglePassword('new_password_confirmation')">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 35px;
            cursor: pointer;
            color: #888;
            z-index: 10;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
