@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Akun Guru</h3>
    <p class="text-subtitle text-muted">Daftar akun guru</p>
</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-2">
        <input type="text" id="search" class="form-control form-control-sm w-auto" placeholder="Cari...">

        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add">
            <i data-feather="plus"></i>
        </button>

        <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/user" method="post">
                        @csrf
                        <input type="hidden" name="userable_type" value="{{ $class }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addLabel">Tambah user guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="users" class="form-label">Daftar guru</label>
                                <input class="form-control" list="teacherList" id="users" placeholder="Cari..." onfocus="this.select()">
                                <input type="hidden" name="userable_id">
                                <datalist id="teacherList">
                                    @foreach($teachers as $teacher)
                                    <option data-value="{{ $teacher->id }}" value="{!! $teacher->nama !!}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control form-control-sm" id="username">
                            </div>
                            <div class="form-group">
                                <label for="username">Password</label>
                                <input type="password" name="password" id="password-add" class="form-control form-control-sm" minlength="5" disabled required>
                                <input type="checkbox" class="form-check-input" types="default" id="default-add" data-id="add" checked>
                                <label class="form-check-label" for="default-add">
                                    Default
                                </label>
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
                                            <input type="checkbox" name="subGrade[]" class="form-check-input" id="subGrade-{{ $subGrade->id }}" value="{{ $subGrade->id }}">
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
                                            <input type="checkbox" name="subject[]" class="form-check-input" id="subject-{{ $subject->id }}" value="{{ $subject->id }}">
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

    </div>


    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{!! $user->userable->nama !!}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $user->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $user->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/user" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $user->id }}Label">{!! $user->userable->nama !!}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" name="username" class="form-control form-control-sm" value="{{ $user->username }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Password</label>
                                                <input type="password" name="password" id="password-{{ $user->id }}" class="form-control form-control-sm" minlength="5" disabled required>
                                                <input type="checkbox" name="change" class="form-check-input" types="not" id="not-{{ $user->id }}" data-id="{{ $user->id }}" value="1" checked>
                                                <label class="form-check-label" for="not-{{ $user->id }}">
                                                    Abaikan
                                                </label>
                                                <input type="checkbox" class="form-check-input" types="default" id="default-{{ $user->id }}" data-id="{{ $user->id }}" disabled>
                                                <label class="form-check-label" for="default-{{ $user->id }}">
                                                    Default
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="level">Role</label>
                                                <select name="level" class="form-select form-select-sm">
                                                    <option value="2" {{ $user->level == '2' ? 'selected' : '' }}>Guru bidang</option>
                                                    <option value="3" {{ $user->level == '3' ? 'selected' : '' }}>Wali kelas</option>
                                                    <option value="4" {{ $user->level == '4' ? 'selected' : '' }}>Operator</option>
                                                    @can('admin')
                                                    <option value="5" {{ $user->level == '5' ? 'selected' : '' }}>Admin</option>
                                                    @endcan
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="row g-2">
                                                    <div class="col-12 col-md-6">
                                                        <label for="subGrade">Kelas</label>
                                                        @foreach($subGrades as $subGrade)
                                                        <div class="form-check">
                                                            <input type="checkbox" name="subGrade[]" class="form-check-input" id="subGrade-{{ $user->id . ' ' . $subGrade->id }}" value="{{ $subGrade->id }}" {{ $user->subGrade->pluck('id')->contains($subGrade->id) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="subGrade-{{ $user->id . ' ' . $subGrade->id }}">
                                                                {{ $subGrade->sub_grade }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="subject">Pelajaran</label>
                                                        @foreach($subjects as $subject)
                                                        <div class="form-check">
                                                            <input type="checkbox" name="subject[]" class="form-check-input" id="subject-{{ $user->id . ' ' . $subject->id }}" value="{{ $subject->id }}" {{ $user->subject->pluck('id')->contains($subject->id) ? 'checked' : '' }}>

                                                            <label class="form-check-label" for="subject-{{ $user->id . ' ' . $subject->id }}">
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
                        <td class="text-center">
                            <form action="/user/{{ $user->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user {!! $user->userable->nama !!}')"><i data-feather="trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links() }}

</section>

@push('scripts')
<script src="{{ asset('js/operator/users.js') }}"></script>
@endpush

@endsection
