@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Kompetensi Dasar</h3>
    <p class="text-subtitle text-muted">Daftar kompetensi dasar</p>
</div>

<hr>

<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/teacher/competences" method="get" class="d-flex" id="search-competences">
                <select name="subject" class="form-select form-select-sm w-auto me-2" id="subject">
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selected['subject'] == $subject->id ? 'selected' : '' }}>{{
                        $subject->subject }}</option>
                    @endforeach
                </select>
                <select name="grade_id" class="form-select form-select-sm w-auto" id="grade">
                    <option hidden></option>
                    @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $selected['grade'] == $grade->id ? 'selected' : '' }}>{{ $grade->grade }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-0 text-md-end">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-competence">
                <i data-feather="plus"></i>
            </button>
            <div class="modal fade" id="add-competence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-competenceLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/teacher/competences" method="post">
                            @csrf
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white" id="add-competenceLabel">Tambah kompetensi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="competence">Kode</label>
                                            <div class="input-group">
                                                <select name="type" class="form-select form-select-sm" id="type">
                                                    <option value="1">3.</option>
                                                    <option value="2">4.</option>
                                                </select>
                                                <input type="number" step="1" name="competence" class="form-control form-control-sm" style="width:50%" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="subject">Pelajaran</label>
                                            <select name="subject_id" class="form-select form-select-sm" required>
                                                @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ $selected['subject']==$subject->id
                                                    ? 'selected' : '' }}>{{ $subject->subject }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kkm">KKM</label>
                                            <input type="number" name="kkm" class="form-control form-control-sm" step="0.1" min="0" max="100" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="grade">Kelas</label>
                                            <select name="grade_id" class="form-select form-select-sm" required>
                                                @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}" {{ $selected['grade'] == $grade->id ? 'selected'
                                                    : '' }}>{{ $grade->grade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="value">Kompetensi</label>
                                            <textarea name="value" class="form-control form-control-sm" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="summary">Deskripsi <strong>(75 Karakter)</strong></label>
                                            <textarea name="summary" class="form-control form-control-sm" maxlength="75" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#upload-competence">
                <i data-feather="upload"></i>
            </button>
            <div class="modal fade" id="upload-competence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-competenceLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/teacher/competences/import" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white" id="add-competenceLabel">Upload kompetensi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <label for="grade">Kelas</label>
                                        <select name="grade_id" class="form-select form-select-sm">
                                            @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <label for="subject">Pelajaran</label>
                                        <select name="subject_id" class="form-select form-select-sm">
                                            @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{$subject->subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="upload">Pilih File</label>
                                        <input class="form-control" name="file" type="file" id="upload" required accept=".xlsx">
                                        <small class="text-muted fw-bold"><em id="size"></em></small>
                                    </div>
                                    <a href="{{ asset('template/Template Kompetensi.xlsx') }}" download><small>Download Template</small></a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
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

    @if($import = session('import'))
    <x-alert-dropdown :total="$import->getRowCount('total')" :success="$import->getRowCount('success')" :failures="$import->failures()" />
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Ringkasan</th>
                        <th>KKM</th>
                        <th>Kelas</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($competences as $competence)
                    <tr>
                        <td class="text-center">{{ $competence->format_competence }}</td>
                        <td><span class="short">{{ $competence->value }}</span></td>
                        <td><span class="short">{{ $competence->summary  }}</span></td>
                        <td class="text-center">{{ $competence->kkm }}</td>
                        <td class="text-center">{{ $competence->grade->grade }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#competence-{{ $competence->id }}"><i data-feather="edit"></i></button>
                        </td>
                        <div class="modal fade" id="competence-{{ $competence->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="competence-{{ $competence->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/teacher/competences" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $competence->id }}">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title text-white" id="competence-{{ $competence->id }}Label">Update Kompetensi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="competence">Kode</label>
                                                        <div class="input-group">
                                                            <select name="type" class="form-select form-select-sm" id="type">
                                                                <option value="1" {{ $competence->type == '1' ? 'selected' : '' }}>3.</option>
                                                                <option value="2" {{ $competence->type == '2' ? 'selected' : '' }}>4.</option>
                                                            </select>
                                                            <input type="number" step="1" name="competence" class="form-control form-control-sm" value="{{ Str::after($competence->competence, '.') }}" style="width:50%">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="subject">Pelajaran</label>
                                                        <select name="subject_id" class="form-select form-select-sm" required>
                                                            @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}" {{ $selected['subject']== $subject->id ? 'selected' : '' }}>{{ $subject->subject }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="kkm">KKM</label>
                                                        <input type="number" name="kkm" class="form-control form-control-sm" step="0.1" min="0" max="100" value="{{ $competence->kkm }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="grade">Kelas</label>
                                                        <select name="grade_id" class="form-select form-select-sm">
                                                            @foreach($grades as $grade)
                                                            <option value="{{ $grade->id }}" {{ $competence->grade->id == $grade->id ? 'selected' : '' }}>{{ $grade->grade }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="value">Komepetensi</label>
                                                        <textarea name="value" class="form-control form-control-sm">{{ $competence->value }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="summary">Deskripsi <strong>(75 Karakter)</strong></label>
                                                        <textarea name="summary" class="form-control form-control-sm" maxlength="75">{{ $competence->summary }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <td class="text-center">
                            <form action="/teacher/competences/{{ $competence->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kompetensi {{ $competence->format_competence }}')">
                                    <i data-feather="trash"></i>
                                </button>
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
<script src="{{ asset('js/competence.js') }}"></script>
@endpush

@endsection
