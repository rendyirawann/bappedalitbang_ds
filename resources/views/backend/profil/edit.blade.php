<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.profil.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">Edit Berkas Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama File / Keterangan Berkas</label>
                        <textarea name="namaFile" class="form-control" rows="4" required>{{ $item->namaFile }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Ganti Berkas (Opsional)</label>
                        <input type="file" name="file" class="form-control-file">
                        <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah berkas.</small>
                        <small class="text-muted">Mendukung: PDF, DOCX, XLSX, ZIP, JPG, PNG (Maks 10MB).</small>
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
