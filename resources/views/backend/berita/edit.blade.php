@extends('backend.layouts.app')
@section('title', 'Edit Berita Perencanaan')

@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Berita Perencanaan</a></li>
                <li class="breadcrumb-item active">Edit Berita</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <h3>Edit Berita: {{ Str::limit(strip_tags($model->judulBerita), 50) }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.berita.update', $model->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold">Gambar Saat Ini:</label><br>
                                <img src="{{ asset('storage/uploads/berita/' . $model->file) }}" class="img-thumbnail"
                                    width="200">
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="font-weight-bold">Ganti Gambar Utama (Opsional)</label>
                                    <input type="file" name="file_doc" class="form-control-file" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Judul Berita <span class="text-danger">*</span></label>
                            <textarea name="judulBerita" class="form-control" rows="2" required>{{ $model->judulBerita }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Isi Berita <span class="text-danger">*</span></label>
                            <textarea name="isiBerita" id="editorIsi" class="form-control">{{ $model->isiBerita }}</textarea>
                        </div>

                        <div class="row">
                            @if (in_array(auth()->user()->username, ['developer', 'admin', 'operator']))
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold">Pilih Bidang Berita</label>
                                    <select name="bidang_id" class="form-control" required>
                                        @foreach ($bidangs as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $model->bidang_id == $b->id ? 'selected' : '' }}>{{ $b->bidang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Tanggal Berita <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_berita" class="form-control"
                                    value="{{ $model->tgl_berita }}" required>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Status Berita</label>
                                <select name="status" class="form-control" required>
                                    <option value="0" {{ $model->status == 0 ? 'selected' : '' }}>Review Berita
                                    </option>
                                    <option value="1" {{ $model->status == 1 ? 'selected' : '' }}>Berita Publish
                                    </option>
                                    <option value="2" {{ $model->status == 2 ? 'selected' : '' }}>Berita di Tolak
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $model->keterangan }}</textarea>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Berita</button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editorIsi')).catch(error => {
            console.error(error);
        });
    </script>
@endpush
