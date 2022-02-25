<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/user" method="post">
                @csrf @method('put')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <input type="hidden" name="userable_type" value="{{ $class }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">{!! $user->nama !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm" value="{{ $user->username }}" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-sm" minlength="5" disabled required>
                        <input type="checkbox" name="change" class="form-check-input" types="not" id="not" value="1" checked>
                        <label class="form-check-label" for="not">
                            Abaikan
                        </label>
                        <input type="checkbox" class="form-check-input" types="default" id="default" disabled>
                        <label class="form-check-label" for="default">
                            Default
                        </label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
