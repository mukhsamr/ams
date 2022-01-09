@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Mata Pelajaran</h3>
    <p class="text-subtitle text-muted">Daftar Mata Pelajaran</p>
</div>
<hr>
<section class="section">
    <div class="mb-2">
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add">
            <i data-feather="plus"></i>
        </button>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#upload">
            <i data-feather="upload"></i>
        </button>

        <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/subjects" method="post">
                        @csrf
                        <div class="modal-header bg-success">
                            <h5 class="modal-title text-white" id="addLabel">Tambah Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="subject" class="form-label">Nama</label>
                                <input type="text" name="subject" class="form-control form-control-sm" id="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="english" class="form-label">English</label>
                                <input type="text" name="english" class="form-control form-control-sm" id="english">
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="raport" type="checkbox" role="switch" id="raport" value="1">
                                <label class="form-check-label" for="raport">Raport</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="local_content" type="checkbox" role="switch" id="local" value="1">
                                <label class="form-check-label" for="local">Muatan Lokal</label>
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
        <div class="modal fade" id="upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/subjects/import" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="uploadLabel">Upload Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="import" class="form-label">Pilih File</label>
                                <input class="form-control" name="import" type="file" id="import" required accept=".xlsx" required>
                                <small class="text-muted fw-bold"><em id="size"></em></small>
                            </div>
                            <a href="{{ asset('template/Template Mapel.xlsx') }}" download><small>Download Template</small></a>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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

    @if($import = session('import'))
    <x-alert-dropdown :total="$import->getRowCount('total')" :success="$import->getRowCount('success')" :failures="$import->failures()" />
    @endif

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>English</th>
                        <th>Raport</th>
                        <th>Muatan Lokal</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                        <td>{{ $subject->subject }}</td>
                        <td>{{ $subject->english }}</td>
                        <td class="text-center">{!! $subject->raport ? '<i data-feather="check" class="text-success"></i>' : '<i data-feather="x" class="text-danger"></i>' !!}</td>
                        <td class="text-center">{!! $subject->local_content ? '<i data-feather="check" class="text-success"></i>' : '<i data-feather="x" class="text-danger"></i>' !!}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $subject->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $subject->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $subject->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="/subjects" method="post">
                                    @csrf @method('put')
                                    <input type="hidden" name="id" value="{{ $subject->id }}">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title" id="edit-{{ $subject->id }}Label">{{ $subject->subject }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="subject-{{ $subject->id }}" class="form-label">Nama</label>
                                                <input type="text" name="subject" class="form-control form-control-sm" id="subject-{{ $subject->id }}" value="{{ $subject->subject }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="english-{{ $subject->id }}" class="form-label">English</label>
                                                <input type="text" name="english" class="form-control form-control-sm" id="english-{{ $subject->id }}" value="{{ $subject->english }}">
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="raport" type="checkbox" role="switch" id="raport-{{ $subject->id }}" value="1" {{ $subject->raport ? 'checked' : '' }}>
                                                <label class="form-check-label" for="raport-{{ $subject->id }}">Raport</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="local_content" type="checkbox" role="switch" id="local-{{ $subject->id }}" value="1" {{ $subject->local_content ? 'checked' : '' }}>
                                                <label class="form-check-label" for="local-{{ $subject->id }}">Muatan Lokal</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <td class="text-center">
                            <form action="/subjects/{{ $subject->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus {{ $subject->subject }}')"><i data-feather="trash"></i></button>
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
<script src="{{ asset('js/admin/subjects.js') }}"></script>
@endpush

@endsection
