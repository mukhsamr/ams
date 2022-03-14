@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Daftar Hadir</h3>
    <p class="text-subtitle text-muted">Daftar hadir siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/guardian/attendance" method="get" class="d-flex">
                <input type="date" name="filter" class="form-control form-control-sm w-auto" max="{{ date('Y-m-d') }}" value="{{ $filtered }}" onchange="this.form.submit()">
            </form>
        </div>
        @if(! $holiday)
        <div class="col-12 col-md-6 order-1 order-md-0 text-md-end">
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit">
                <i data-feather="edit"></i>
            </button>
        </div>
        <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="/attendance" method="post">
                        @csrf @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLabel">Edit daftar kehadiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="text-center">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                    <tr>
                                        <td>{!! $attendance->nama !!}</td>
                                        <td class="text-center">
                                            <select name="student[{{ $attendance->user_id }}][status]" class="form-select form-select-sm w-auto">
                                                @foreach(['Tepat Waktu', 'Terlambat', 'Izin', 'Sakit', 'Alpha'] as $value)
                                                <option value="{{ $value }}" {{ selected($value == $attendance->status) }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="text" name="student[{{ $attendance->user_id }}][etc]" class="form-control form-control-sm" value="{{ $attendance->etc }}">
                                        </td>
                                    </tr>
                                    <input type="hidden" name="student[{{ $attendance->user_id }}][id]" value="{{ $attendance->id }}">
                                    <input type="hidden" name="student[{{ $attendance->user_id }}][user_id]" value="{{ $attendance->user_id }}">
                                    <input type="hidden" name="student[{{ $attendance->user_id }}][date]" value="{{ $attendance->date ?? $filtered }}">
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card mb-2">
        @if($holiday)
        <div class="card-body">
            <span class="badge bg-danger">{{ $holiday['event'] }}</span>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td>{!! $attendance->nama !!}</td>
                        <td class="text-center">{!! $attendance->format_status !!}</td>
                        <td class="text-center">{{ $attendance->etc }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div id="modal"></div>
</section>

@push('scripts')
<script src="{{ asset('js/operator/attendance.js') }}"></script>
@endpush

@endsection
