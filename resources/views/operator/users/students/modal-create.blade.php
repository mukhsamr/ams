<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/user" method="post">
                @csrf
                <input type="hidden" name="userable_type" value="{{ $class }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">Tambah user siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="users" class="form-label">Daftar siswa</label>
                        <select name="userable_id" class="form-select form-select-sm">
                            @foreach($students as $student)
                            <option value="{{ $student->id }}">{!! $student->nama !!}</option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" list="studentList" id="users" placeholder="Cari..."
                            onfocus="this.select()">
                        <input type="hidden" name="userable_id">
                        <datalist id="studentList">
                            @foreach($students as $student)
                            <option data-value="{{ $student->id }}" value="{!! $student->nama !!}"></option>
                            @endforeach
                        </datalist> --}}
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Password</label>
                        <input type="password" name="password" id="password-create" class="form-control form-control-sm"
                            minlength="5" disabled required>
                        <input type="checkbox" class="form-check-input" types="default" id="default-create"
                            data-id="create" checked>
                        <label class="form-check-label" for="default-create">
                            Default
                        </label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>