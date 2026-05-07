<div class="modal fade" id="modalShow{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $p->namaLengkap }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $p->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Aparatur</th>
                        <td>{{ $p->statusAparatur == 1 ? 'ASN' : 'Non-ASN' }}</td>
                    </tr>
                    <tr>
                        <th>Bidang</th>
                        <td>{{ $p->bidang->bidang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Eselon</th>
                        <td>{{ $p->pegawaiEselon->nm_eselon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan (Title)</th>
                        <td>{{ $p->title->title ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $p->no_hp ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
