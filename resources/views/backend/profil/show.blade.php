<div class="modal fade" id="modalShow{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalShowLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalShowLabel{{ $item->id }}">Detail Berkas Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%" class="bg-light">Keterangan / Nama File</th>
                        <td>{{ $item->namaFile }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tanggal Upload</th>
                        <td>
                            @if ($item->tanggalUpload)
                                {{ \Carbon\Carbon::parse($item->tanggalUpload)->format('d M Y H:i:s') }}
                            @else
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i:s') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Berkas Sistem</th>
                        <td><span class="badge badge-info">{{ $item->file }}</span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.profil.download', $item->id) }}" class="btn btn-success"><i
                        class="fa fa-download"></i> Unduh Berkas</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
