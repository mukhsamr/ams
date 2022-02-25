@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Setelan</h3>
    <p class="text-subtitle text-muted">Konfigurasi data sekolah</p>
</div>
<hr>

<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama Sekolah</th>
                        <th>Logo</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <td>{{ $school->name }}</td>
                    <td class="text-center">
                        <img src="{{ $school->logo }}" alt="logo" width="100">
                    </td>
                    <td class="text-center"><button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#school_setting">
                            <i data-feather="edit"></i>
                        </button>
                    </td>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="school_setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="school_settingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('school_setting') }}" method="post" enctype="multipart/form-data">
                    @csrf @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="school_settingLabel">Setelan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                value="{{ $school->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="logo" class="form-label">Logo</label>
                            <input class="form-control" name="logo" type="file" id="logo" data-preview="logo-prev"
                                accept="image/*">
                        </div>
                        <img src="{{ $school->logo }}" id="logo-prev" class="img-thumbnail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Kepala Sekolah</th>
                        <th>Tanda Tangan</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <td>{!! $school->teacher->nama !!}</td>
                    <td class="text-center">
                        <img src="{{ $school->signature }}" alt="signature" width="100">
                    </td>
                    <td class="text-center"><button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#headmaster_setting">
                            <i data-feather="edit"></i>
                        </button>
                    </td>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="headmaster_setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="headmaster_settingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('headmaster_setting') }}" method="post" enctype="multipart/form-data">
                    @csrf @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="headmaster_settingLabel">Setelan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="headmaster">Kepala Sekolah</label>
                            <select name="teacher_id" id="headmaster" class="form-select form-select-sm">
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ selected($teacher->id == $school->teacher_id)
                                    }}>{!!
                                    $teacher->nama !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="signature" class="form-label">Tanda Tangan</label>
                            <input class="form-control" name="signature" type="file" id="signature"
                                data-preview="signature-prev" accept="image/*">
                        </div>
                        <img src="{{ $school->signature }}" id="signature-prev" class="img-thumbnail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/admin/schools.js') }}"></script>
@endpush

@endsection