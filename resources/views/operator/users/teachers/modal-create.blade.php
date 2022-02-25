<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/user" method="post">
                @csrf
                <input type="hidden" name="userable_type" value="{{ $class }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">Tambah user guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="users" class="form-label">Daftar guru</label>
                        <select name="userable_id" id="users" class="form-select form-select-sm" required>
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{!! $teacher->nama !!}</option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" list="teacherList" id="users" placeholder="Cari..."
                            onfocus="this.select()">
                        <input type="hidden" name="userable_id">
                        <datalist id="teacherList">
                            @foreach($teachers as $teacher)
                            <option data-value="{{ $teacher->id }}" value="{!! $teacher->nama !!}"></option>
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
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" name="status" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label for="level">Role</label>
                        <select name="level" class="form-select form-select-sm">
                            <option value="2">Guru bidang</option>
                            <option value="3">Wali kelas</option>
                            <option value="4">Operator</option>
                            @can('admin')
                            <option value="5">Admin</option>
                            @endcan
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row g-2">
                            <div class="col-12 col-md-6">
                                <label for="subGrade">Kelas</label>
                                @foreach($subGrades as $subGrade)
                                <div class="form-check">
                                    <input type="checkbox" name="subGrade[]" class="form-check-input"
                                        id="subGrade-{{ $subGrade->id }}" value="{{ $subGrade->id }}">
                                    <label class="form-check-label" for="subGrade-{{ $subGrade->id }}">
                                        {{ $subGrade->sub_grade }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="subject">Pelajaran</label>
                                @foreach($subjects as $subject)
                                <div class="form-check">
                                    <input type="checkbox" name="subject[]" class="form-check-input"
                                        id="subject-{{ $subject->id }}" value="{{ $subject->id }}">
                                    <label class="form-check-label" for="subject-{{ $subject->id }}">
                                        {{ $subject->subject }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
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