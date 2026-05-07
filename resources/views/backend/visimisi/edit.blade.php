<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.visimisi.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">Edit Visi & Misi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Visi</label>
                        <textarea name="visiJudul" id="visiJudulEdit{{ $item->id }}" class="form-control" rows="2">{{ $item->visiJudul }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Teks Visi</label>
                        <textarea name="visiTeks" id="visiTeksEdit{{ $item->id }}" class="form-control" rows="4">{{ $item->visiTeks }}</textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Misi</label>
                        <textarea name="misiJudul" id="misiJudulEdit{{ $item->id }}" class="form-control" rows="2">{{ $item->misiJudul }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Teks Misi</label>
                        <textarea name="misiTeks" id="misiTeksEdit{{ $item->id }}" class="form-control" rows="4">{{ $item->misiTeks }}</textarea>
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
