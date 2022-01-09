@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Akun Siswa</h3>
    <p class="text-subtitle text-muted">Daftar akun siswa</p>
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
                            <h5 class="modal-title" id="addLabel">Tambah user siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="users" class="form-label">Daftar siswa</label>
                                <input class="form-control" list="studentList" id="users" placeholder="Cari..." onfocus="this.select()">
                                <input type="hidden" name="userable_id">
                                <datalist id="studentList">
                                    @foreach($students as $student)
                                    <option data-value="{{ $student->id }}" value="{!! $student->nama !!}"></option>
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
                                <input type="checkbox" class="form-check-input" id="default-add" data-id="add" checked>
                                <label class="form-check-label" for="default-add">
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
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{!! $user->userable->nama !!}</td>
                        <td>{{ $user->username }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $user->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $user->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/user/{{ $user->id }}" method="post">
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
