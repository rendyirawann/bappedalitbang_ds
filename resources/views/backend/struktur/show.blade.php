<div class="modal fade" id="modalShow{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalShowLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalShowLabel{{ $item->id }}">Detail
                    Struktur: {{ $item->namaFile }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4 class="mb-4">{{ $item->namaFile }}</h4>
                <img src="{{ asset('storage/uploads/struktur/' . $item->file) }}" alt="Struktur"
                    class="img-fluid img-thumbnail" style="max-width: 100%; height: auto;">
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.struktur.download', $item->id) }}" class="btn btn-success"><i
                        class="fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
