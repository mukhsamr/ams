@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Kompetensi Dasar</h3>
    <p class="text-subtitle text-muted">Daftar kompetensi dasar kelas <strong>{{ $grade->grade }}</strong></p>
</div>

<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-4 order-2 order-md-0">
            <form action="/guardian/competences" method="get" id="search-competences">
                <select name="subject" class="form-select form-select-sm" id="subject">
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ selected($selected == $subject->id) }}>{{ $subject->subject }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="col-12 col-md-8 order-1 order-md-0 text-md-end">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-competence">
                <i data-feather="plus"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#upload-competence">
                <i data-feather="upload"></i>
            </button>
        </div>

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
                                        <label for="subject">Pelajaran</label>
                                        <select name="subject_id" class="form-select form-select-sm" required>
                                            @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="grade">Kelas</label>
                                        <select name="grade_id" class="form-select form-select-sm">
                                            <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
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
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="kkm">KKM</label>
                                        <input type="number" name="kkm" class="form-control form-control-sm" step="0.1" min="0" max="100" required>
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
                                        <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
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
                                    <label for="import">Pilih File</label>
                                    <input class="form-control" name="import" type="file" id="import" required accept=".xlsx">
                                    <small class="text-muted fw-bold"><em id="size"></em></small>
                                </div>
                                <a href="{{ asset('template/Template Kompetensi.xlsx') }}" download><small>Download Tempate</small></a>
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

    @if($errors->any())
    <x-alert type="warning" :warning="implode(',', $errors->all())" />
    @endif

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
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
                        <th>Kompetensi</th>
                        <th>Deskripsi</th>
                        <th>KKM</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($competences as $competence)
                    <tr>
                        <td class="text-center">{{ $competence->format_competence }}</td>
                        <td><span class="short">{{ $competence->value }}</span></td>
                        <td><span class="short">{{ $competence->summary }}</span></td>
                        <td class="text-center">{{ $competence->kkm }}</td>
                        <td class="text-center">
                            <a href="/guardian/competences/edit/{{ $competence->id }}" class="btn btn-sm btn-info load-modal" data-target="#edit"><i data-feather="edit"></i></a>
                        </td>
                        <td class="text-center">
                            <form action="/teacher/competences/{{ $competence->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kompetensi {{ $competence->format_competence }}')" {{ disabled($competence->used) }}>
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

    <div id="modal"></div>
    {{ $competences->links() }}
</section>

@push('scripts')
<script src="{{ asset('js/guardian/competence.js') }}"></script>
@endpush

@endsection
