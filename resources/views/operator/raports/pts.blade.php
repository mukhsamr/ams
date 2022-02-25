@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>PTS</h3>
    <p class="text-subtitle text-muted">Raport PTS kelas <strong>{{ $subGrade->sub_grade ?? null }}</strong></p>
</div>
<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/operator/raports/pts" class="row g-1">
                <div class="col-10 col-md-7 d-flex">
                    <select name="subGrade" id="subGrade" class="form-select form-select-sm w-auto" required
                        onchange="this.form.submit()">
                        @foreach ($subGrades as $sub_grade)
                        <option value="{{ $sub_grade->id }}" {{ selected($sub_grade->id == $selected) }}>{{
                            $sub_grade->sub_grade }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama" id="nama" required>
                    <input class="form-control form-control-sm" list="listNama" id="student" placeholder="Nama..."
                        required value="{{ $student }}">
                    <datalist id="listNama">
                        @foreach($students as $student) <option data-id="{{ $student->id }}"
                            value="{!! $student->nama !!}"> @endforeach
                    </datalist>
                </div>
                <div class="col-2 col-md-3">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i data-feather="search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 orser-md-0 text-md-end">
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#setting">
                <i data-feather="settings"></i>
            </button>
            <form action="{{ route('raport_pts_pdf') }}" method="post" class="d-inline-flex">
                @csrf
                <input type="hidden" name="nama" value="{{ $nama }}">
                <input type="hidden" name="subGrade" value="{{ $subGrade->id ?? null }}">
                <button type="submit" class="btn btn-sm btn-danger" {{ disabled(!$nama) }}>PDF</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="settingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('raport_setting') }}" method="post">
                    @csrf @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingLabel">Setelan Raport</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="pts">
                        <div class="form-group">
                            <label for="place">Tempat, waktu</label>
                            <input type="text" name="place" class="form-control form-control-sm" placeholder="..."
                                value="{{ $setting->place }}" required>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="background" value="1"
                                    role="switch" id="background" {{ checked($setting->background) }}>
                                <label class="form-check-label" for="background">Background</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">No</th>
                        <th class="text-center" rowspan="2">Subjects</th>
                        @foreach($columns as $column)
                        <th class="text-center" colspan="2">BC {{ $column }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($columns as $column)
                        <th class="text-center">C</th>
                        <th class="text-center">S</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($raports as $subject => $values)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <td>{{ $subject }}</td>
                        @forelse ($values as $key => $value)

                        @if ($loop->iteration > count($columns)) @break @endif

                        <td class="text-center">{{ $value["3_$key"] ?? '-' }}</td>
                        <td class="text-center">{{ $value["4_$key"] ?? '-' }}</td>

                        @if ($loop->last && $loop->iteration < count($columns)) @for ($i=0; $i < (count($columns) -
                            $loop->iteration); $i++)
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            @endfor
                            @endif

                            @empty
                            @foreach ($columns as $column)
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            @endforeach
                            @endforelse
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/guardian/raport.js') }}"></script>
@endpush

@endsection