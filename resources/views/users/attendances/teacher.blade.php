@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Daftar Hadir</h3>
</div>
<hr>

<section class="section">
    <button type="button" class="btn btn-dark btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#info">
        <i data-feather="info"></i>
    </button>

    <div class="card mb-2">
        <div class="modal fade" id="info" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoLabel">Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            @foreach($info as $v)
                            <div class="col-12">
                                <strong>{{ $v->status }}</strong>
                                <span class="badge bg-{{ attendanceColor($v->status) }} ms-3">{{ $v->count }}</span>
                            </div>
                            @endforeach
                            {{-- <div class="col-12">
                                <strong>Tanpa Keterangan</strong>
                                <span class="text-secondary ms-3">4</span>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->format_date }}</td>
                        <td class="text-center">{{ $attendance->hours }}</td>
                        <td class="text-center">{!! $attendance->format_status !!}</td>
                        <td class="text-center">{{ $attendance->etc }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $attendances->links() }}
</section>


@endsection
