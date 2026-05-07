<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.galeri.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">Edit Galeri Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama / Keterangan Galeri</label>
                        <input type="text" name="namaFile" class="form-control" value="{{ $item->namaFile }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Gambar Saat Ini</label><br>
                        <img src="{{ asset('uploads/galeri/' . $item->file) }}" alt="Preview" width="150"
                            class="img-thumbnail mb-2">
                    </div>
                    <div class="form-group">
                        <label>Ganti Gambar (Opsional)</label>
                        <input type="file" name="file" class="form-control-file" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
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
