@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Daftar Hadir</h3>
    <p class="text-subtitle text-muted">Daftar hadir guru</p>
</div>
<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/operator/attendance/teacher" method="get" class="d-flex">
                <input type="date" name="filter" class="form-control form-control-sm w-auto" max="{{ date('Y-m-d') }}" value="{{ $filtered }}" onchange="this.form.submit()">
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-0 text-md-end">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#qr">
                <i data-feather="slack"></i>
            </button>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#setting">
                <i data-feather="settings"></i>
            </button>
            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#export">
                <i data-feather="download"></i>
            </button>
        </div>
        <div class="modal fade" id="qr" tabindex="-1" aria-labelledby="qrLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrLabel">QRCode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div>{!! $qrcode !!}</div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <form action="/operator/attendance/qrcode/teacher" method="post">
                            @csrf @method('put')
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Perbaharui QRCode')">Perbaharui</button>
                        </form>
                        <a href="/operator/attendance/qrcode/teacher" class="btn btn-primary" onclick="return confirm('Download QRCode?')">Download</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="settingLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/operator/attendance/setting" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="settingLabel">Setelan absensi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="type" value="teacher">
                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                    <label for="start">Mulai</label>
                                    <input type="time" name="start" class="form-control form-control-sm" value="{{ $setting->start }}" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="end">Batas Waktu</label>
                                    <input type="time" name="end" class="form-control form-control-sm" value="{{ $setting->end }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="holiday">Libur</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="sat" type="checkbox" role="switch" id="sat" value="1" {{ $setting->sat ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sat">Sabtu</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="sun" type="checkbox" role="switch" id="sun" value="1" {{ $setting->sun ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sun">Ahad</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="export" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/operator/attendance/teacher/export" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportLabel">Download Absensi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                    <label for="start">Mulai</label>
                                    <input type="date" name="start" class="form-control form-control-sm" max="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="end">Sampai</label>
                                    <input type="date" name="end" class="form-control form-control-sm" max="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-dark">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        <div class="card-body">
            <form action="/attendance/barcode" class="d-flex" method="post">
                @csrf
                <div class="input-group w-auto">
                    <input type="text" name="username" class="form-control form-control-sm" placeholder="Username..." autofocus required>
                    <button type="submit" class="btn btn-primary btn-sm">Konfirmasi</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Datang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td>{!! $attendance->nama !!}</td>
                        <td class="text-center">{{ $attendance->hours }}</td>
                        <td class="text-center">{!! $attendance->format_status !!}</td>
                        <td class="text-center">{{ $attendance->etc }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $attendance->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $attendance->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $attendance->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/operator/attendance" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $attendance->id }}">
                                        <input type="hidden" name="user_id" value="{{ $attendance->user_id }}">
                                        <input type="hidden" name="date" value="{{ $attendance->date ?? $filtered }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $attendance->id }}Label">{{ $attendance->format_date }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="col-12 col-md-6">
                                                    <label for="hours">Datang</label>
                                                    <input type="time" name="hours" class="form-control form-control-sm" value="{{ $attendance->hours }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="status">Status</label>
                                                    <select name="status" class="form-select form-select-sm">
                                                        @foreach(['Tepat Waktu', 'Terlambat', 'Izin', 'Sakit'] as $value)
                                                        <option value="{{ $value }}" {{ selected($value == $attendance->status) }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label for="etc">Keterangan</label>
                                                    <textarea name="etc" class="form-control form-control-sm">{{ $attendance->etc }}</textarea>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @if($attendances)
    {{ $attendances->links() }}
    @endif
</section>

@push('scripts')
<script src="{{ asset('js/operator/attendance.js') }}"></script>
@endpush

@endsection
