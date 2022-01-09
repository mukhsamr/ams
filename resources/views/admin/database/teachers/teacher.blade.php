@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Database Guru</h3>
    <p class="text-subtitle text-muted">Data lengkap guru</p>
</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-2">
        <form action="/database/teachers" method="get" id="search">
            <div class="input-group w-auto">
                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Cari nama..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-secondary btn-sm"><i data-feather="search"></i></button>
            </div>
        </form>
        <div>
            <a href="/database/teachers/create" class="btn btn-dark btn-sm"><i data-feather="plus"></i></a>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#upload">
                <i data-feather="upload"></i>
            </button>
            <div class="modal fade" id="upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="/database/teachers/import" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadLabel">Upload Guru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="import">Pilih File</label>
                                    <input type="file" name="import" class="form-control form-control-sm" id="import" accept=".xlsx" required>
                                    <small class="text-muted fw-bold"><em id="size"></em></small>
                                </div>
                                <a href="{{ asset('template/Template Guru.xlsx') }}" download><small>Download Template</small></a>
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
                        @foreach($teachers as $teacher)
                        <tr>
                            <td class="text-center"><a href="/database/teachers/edit/{{ $teacher->id }}"><i data-feather="edit"></i></a></td>

                            @foreach($columns as $key => $column)
                            @if($key < 1) <td>{!! $teacher[$column] !!}</td>
                                @elseif($column == 'foto')
                                <td class="text-center">
                                    @if(isset($teacher[$column]))
                                    <a href="#img-{{ $key }}" data-bs-toggle="collapse"><i data-feather="eye"></i></a>
                                    <div class="collapse" id="img-{{ $key }}">
                                        <img src="{{ asset('storage/img/teachers/' . $teacher[$column]) }}" alt="foto" width="100">
                                    </div>
                                    @endif
                                </td>
                                @else
                                <td>{{ $teacher[$column] }}</td>
                                @endif
                                @endforeach
                                <td class="text-center">
                                    <form action="/database/teachers/{{ $teacher->id }}" method="post" class="delete">
                                        @csrf @method('delete')
                                        <button type="button" class="btn p-1 text-danger delete" data-user="{{ str_replace('&nbsp;', ' ', $teacher->nama) }}"><i data-feather="trash"></i></button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $teachers->links() }}
    </div>

</section>

@push('scripts')
<script src="{{ asset('js/database.js') }}"></script>
@endpush

@endsection
