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
                        <input type="checkbox" name="ignore" class="form-check-input" types="not" id="not" data-id="{{ $user->id }}" value="1" checked>
                        <label class="form-check-label" for="not">
                            Abaikan
                        </label>
                        <input type="checkbox" class="form-check-input" types="default" id="default" data-id="{{ $user->id }}" disabled>
                        <label class="form-check-label" for="default">
                            Default
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" name="status" class="form-control form-control-sm" value="{{ $user->status }}">
                    </div>
                    <div class="form-group">
                        <label for="level">Role</label>
                        <select name="level" class="form-select form-select-sm">
                            <option value="2" {{ selected($user->level == '2') }}>Guru bidang</option>
                            <option value="3" {{ selected($user->level == '3') }}>Wali kelas</option>
                            <option value="4" {{ selected($user->level == '4') }}>Operator</option>
                            @can('admin')
                            <option value="5" {{ selected($user->level == '5') }}>Admin</option>
                            @endcan
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row g-2">
                            <div class="col-12 col-md-6">
                                <label for="subGrade">Kelas</label>
                                @foreach($subGrades as $subGrade)
                                <div class="form-check">
                                    <input type="checkbox" name="subGrade[]" class="form-check-input" id="subGrade-{{ $subGrade->id }}" value="{{ $subGrade->id }}" {{ checked($subGrade->user_id) }}>
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
                                    <input type="checkbox" name="subject[]" class="form-check-input" id="subject-{{ $subject->id }}" value="{{ $subject->id }}" {{ checked($subject->user_id) }}>
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
