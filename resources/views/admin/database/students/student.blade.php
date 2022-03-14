@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Database Siswa</h3>
    <p class="text-subtitle text-muted">Data lengkap siswa</p>
</div>
<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/database/students" method="get" id="search">
                <div class="input-group w-auto">
                    <select name="field" class="form-select form-select-sm" id="field">
                        @foreach(array_slice($columns, 0,-1) as $column)
                        <option value="{{ $column }}" {{ $column == $field ? 'selected' : '' }}>{{ Str::headline($column) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="keyword" class="form-control form-control-sm" placeholder="..." value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-secondary btn-sm"><i data-feather="search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-0 text-md-end">
            <div>
                <a href="/database/students/create" class="btn btn-dark btn-sm"><i data-feather="plus"></i></a>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#upload">
                    <i data-feather="upload"></i>
                </button>
            </div>
        </div>
        <div class="modal fade" id="upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="/database/students/import" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadLabel">Upload Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="import">Pilih File</label>
                                <input type="file" name="import" class="form-control form-control-sm" id="import" accept=".xlsx" required>
                                <small class="text-muted fw-bold"><em id="size"></em></small>
                            </div>
                            <a href="{{ asset('template/Template Siswa.xlsx') }}" download><small>Download Template</small></a>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($import = session('import'))
    <x-alert-dropdown :total="$import->getRowCount('total')" :success="$import->getRowCount('success')" :failures="$import->failures()" />
    @endif

    <div id="load">
        <div class="card mb-2">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="text-center">
                        <tr>
                            <th>Edit</th>
                            @foreach($fields as $field)
                            <th>{{ $field }}</th>
                            @endforeach
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td class="text-center"><a href="/database/students/edit/{{ $student->id }}"><i data-feather="edit"></i></a></td>
                            @foreach($columns as $key => $column)
                            @if($key < 1) <td>{!! $student[$column] !!}</td>
                                @elseif($column == 'foto')
                                <td class="text-center">
                                    @if(isset($student[$column]))
                                    <a href="#img-{{ $key }}" data-bs-toggle="collapse"><i data-feather="eye"></i></a>
                                    <div class="collapse" id="img-{{ $key }}">
                                        <img src="{{ asset('storage/img/students/' . $student[$column]) }}" alt="foto" width="100">
                                    </div>
                                    @endif
                                </td>
                                @else
                                <td>{{ $student[$column] }}</td>
                                @endif
                                @endforeach
                                <td class="text-center">
                                    <form action="/database/students/{{ $student->id }}" method="post" class="delete">
                                        @csrf @method('delete')
                                        <button type="button" class="btn p-1 text-danger delete" data-user="{{ str_replace('&nbsp;', ' ', $student->nama) }}"><i data-feather="trash"></i></button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $students->links() }}
    </div>

</section>

@push('scripts')
<script src="{{ asset('js/database.js') }}"></script>
@endpush

@endsection
