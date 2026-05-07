<div class="modal fade" id="modalShow{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalShowLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalShowLabel{{ $item->id }}">Detail Visi & Misi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-3 border-primary">
                    <div class="card-header bg-primary text-white font-weight-bold">VISI</div>
                    <div class="card-body">
                        <h5 class="card-title">{!! $item->visiJudul !!}</h5>
                        <div class="card-text">{!! $item->visiTeks !!}</div>
                    </div>
                </div>

                <div class="card border-success">
                    <div class="card-header bg-success text-white font-weight-bold">MISI</div>
                    <div class="card-body">
                        <h5 class="card-title">{!! $item->misiJudul !!}</h5>
                        <div class="card-text">{!! $item->misiTeks !!}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
