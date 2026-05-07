<div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Bidang</label>
                        <select name="bidang_id" class="form-control">
                            <option value="">-- Tanpa Bidang --</option>
                            @foreach ($bidangs as $b)
                                <option value="{{ $b->id }}" {{ $user->bidang_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="10" {{ $user->status == 10 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password (Kosongkan jika tidak ganti)</label>
                        <input type="password" name="password" class="form-control">
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
