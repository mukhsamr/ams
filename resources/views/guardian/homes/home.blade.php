@extends('layout.template')

@section('content')
<div class="page-title">
    <h3>Beranda</h3>
    <p class="text-subtitle text-muted">Beranda wali kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>

<section class="section">
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card-header">
                <h5 class="card-title">Jumlah Kompetensi</h5>
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Pelajaran</th>
                                <th>KD3</th>
                                <th>KD4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            <tr>
                                <td>{{ $subject->subject }}</td>
                                <td>{{ $subject->kd_3 }}</td>
                                <td>{{ $subject->kd_4 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Progress Bar</h5>
                </div>
                <div class="card-body">
                    @foreach ($subjects as $subject)
                    <span>{{ $subject->subject }}</span>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="progress h-4">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $subject->progress_kd3 }}%;" aria-valuenow="{{ $subject->progress_kd3 }}" aria-valuemin="0" aria-valuemax="100">{{ $subject->progress_kd3 }}%</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="progress h-4">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $subject->progress_kd4 }}%;" aria-valuenow="{{ $subject->progress_kd4 }}" aria-valuemin="0" aria-valuemax="100">{{ $subject->progress_kd4 }}%</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ketuntasan Nilai</h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pelajaran</th>
                                <th>KD3</th>
                                <th>KD4</th>
                                <th>Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            <tr>
                                <td>{{ $subject->subject }}</td>
                                <td class="{{ tuntasColor($subject->tuntas_3) }}"><strong>{{ $subject->tuntas_3 }}%</strong></td>
                                <td class="{{ tuntasColor($subject->tuntas_4) }}"><strong>{{ $subject->tuntas_4 }}%</strong></td>
                                <td><a href="/guardian/home/{{ $subject->id }}" class="load-modal" data-target="#info"><i data-feather="info"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart" width="100" height="50" data-json="{{ json_encode($subjects) }}"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
</section>

@push('scripts')
<script src="{{ asset('js/guardian/home.js') }}"></script>
@endpush

@endsection
