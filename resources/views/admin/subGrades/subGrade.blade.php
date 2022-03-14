@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Sub Kelas</h3>
    <p class="text-subtitle text-muted">Daftar Sub Kelas</p>
</div>
<hr>
<section class="section">
    <button type="button" class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#add">
        <i data-feather="plus"></i>
    </button>

    <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/subGrades" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLabel">Tambah Sub Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="grade" class="form-label">Kelas</label>
                            <select name="grade_id" id="grade" class="form-select form-select-sm" required
                                onchange="$('#subGrade').val($(this).find(':selected').data('grade'))">
                                <option hidden></option>
                                @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" data-grade="{{ $grade->grade }}">{{ $grade->grade }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subGrade" class="form-label">Sub Kelas</label>
                            <input type="text" name="sub_grade" id="subGrade" class="form-control form-control-sm"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" required>
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
                        <th>Sub Kelas</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subGrades as $subGrade)
                    <tr class="text-center">
                        <td>{{ $subGrade->sub_grade }}</td>
                        <td>{{ $subGrade->name }}</td>
                        <td>{{ $subGrade->grade->grade }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit-{{ $subGrade->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $subGrade->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $subGrade->id }}Label"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/subGrades" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $subGrade->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $subGrade->id }}Label">{{
                                                $subGrade->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="grade" class="form-label">Kelas</label>
                                                <select name="grade_id" id="grade-{{ $subGrade->id }}"
                                                    class="form-select form-select-sm" required
                                                    onchange="$('#subGrade-{{ $subGrade->id }}').val($(this).find(':selected').data('grade'))">
                                                    <option hidden></option>
                                                    @foreach($subGrades->unique('grade') as $unique)
                                                    <option value="{{ $unique->grade->id }}"
                                                        data-grade="{{ $unique->grade->grade }}" {{ $subGrade->grade->id
                                                        == $unique->grade->id ? 'selected' : '' }}>{{
                                                        $unique->grade->grade }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="subGrade" class="form-label">Sub Kelas</label>
                                                <input type="text" name="sub_grade" id="subGrade-{{ $subGrade->id }}"
                                                    class="form-control form-control-sm"
                                                    value="{{ $subGrade->sub_grade }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" name="name" id="name-{{ $subGrade->id }}"
                                                    class="form-control form-control-sm" value="{{ $subGrade->name }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <td>
                            <form action="/subGrades/{{ $subGrade->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus Sub Kelas {{ $subGrade->sub_grade }}')"><i
                                        data-feather="trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection