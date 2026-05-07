<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.pegawai.update', $p->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="namaLengkap" class="form-control" value="{{ $p->namaLengkap }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control" value="{{ $p->nip }}">
                            </div>
                            <div class="form-group">
                                <label>Status Aparatur</label>
                                <select name="statusAparatur" class="form-control" required>
                                    <option value="1" {{ $p->statusAparatur == 1 ? 'selected' : '' }}>ASN</option>
                                    <option value="2" {{ $p->statusAparatur == 2 ? 'selected' : '' }}>
                                        Non-ASN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bidang</label>
                                <select name="kodeBidang" class="form-control">
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach ($bidangs as $b)
                                        <option value="{{ $b->id }}"
                                            {{ $p->kodeBidang == $b->id ? 'selected' : '' }}>{{ $b->bidang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Eselon</label>
                                <select name="eselon" class="form-control">
                                    <option value="">-- Pilih Eselon --</option>
                                    @foreach ($eselons as $e)
                                        <option value="{{ $e->id }}" {{ $p->eselon == $e->id ? 'selected' : '' }}>
                                            {{ $e->nm_eselon }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jabatan (Title)</label>
                                <select name="kodeTitle" class="form-control">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($titles as $t)
                                        <option value="{{ $t->id }}"
                                            {{ $p->kodeTitle == $t->id ? 'selected' : '' }}>{{ $t->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ $p->no_hp }}">
                            </div>
                        </div>
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
