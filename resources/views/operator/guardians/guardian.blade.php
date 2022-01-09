@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Wali Kelas</h3>
    <p class="text-subtitle text-muted">Daftar wali kelas</p>
</div>
<hr>
<section class="section">
    <div class="d-flex mb-3">
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-guardian">
            <i data-feather="plus"></i>
        </button>
        <div class="modal fade" id="add-guardian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-guardianLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/daftar/guardians" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="add-guardianLabel">Tambah Wali Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="subGrade">Kelas</label>
                                        <select name="sub_grade_id" id="subGrade" class="form-select form-select-sm" required>
                                            @foreach($subGrades as $subGrade)
                                            <option value="{{ $subGrade->id }}">{{ $subGrade->sub_grade }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="user">Guru</label>
                                        <select name="user_id" class="form-select form-select-sm" id="user" required>
                                            <option hidden></option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}">{!! $user->userable->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="signature">Tanda Tangan</label>
                                        <input type="file" name="signature" id="signature" data-preview="add" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <img id="add" class="img-thumbnail">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
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
    <x-alert type="warning" :warning="implode(',', $errors->all())" />
    @endif


    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Kelas</th>
                        <th>Nama</th>
                        <th>Tanda&nbsp;Tangan</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guardians as $guardian)
                    <tr>
                        <td class="text-center">{{ $guardian->subGrade->sub_grade }}</td>
                        <td>{!! str_replace(' ', '&nbsp;',$guardian->user->userable->nama) !!}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/img/guardians/'. ($guardian->signature ?: 'signature.png')) }}" alt="signature" class="img-thumbnail" width="100">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#guardian-{{ $guardian->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="guardian-{{ $guardian->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="guardian-{{ $guardian->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/daftar/guardians" method="post" enctype="multipart/form-data">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $guardian->id }}">
                                        <input type="hidden" name="sub_grade_id" value="{{ $guardian->subGrade->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="guardian-{{ $guardian->id }}Label">Kelas {{ $guardian->subGrade->sub_grade }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="user">Guru</label>
                                                        <select name="user_id" class="form-select form-select-sm" id="user">
                                                            <option hidden></option>
                                                            @foreach($users as $user)
                                                            <option value="{{ $user->id }}" {{ $user->id == $guardian->user->id ? 'selected' : '' }}>{!! $user->userable->nama !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="signature">Tanda Tangan</label>
                                                        <input type="file" name="signature" data-preview="u-{{ $guardian->id }}" id="signature" class="form-control form-control-sm" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <img src="{{ asset('storage/img/guardians/'. ($guardian->signature ?: 'signature.png')) }}" id="u-{{ $guardian->id }}" class="img-thumbnail">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <td class="text-center">
                            <form action="/daftar/guardians/{{ $guardian->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus wali kelas {{ $guardian->subGrade->sub_grade }}?')"><i data-feather="trash"></i></button>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>

@push('scripts')
<script src="{{ asset('js/guardians.js') }}"></script>
@endpush

@endsection
