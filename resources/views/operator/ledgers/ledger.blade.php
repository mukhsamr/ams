@extends('layout.template')

@section('content')

@php
$table = session(request()->path());
@endphp

<div class="page-title">
    <h3>Ledger</h3>
    <p class="text-subtitle text-muted">Rekap nilai harian.</p>
</div>
<hr>
<section class="section">
    <div class="row">
        <div class="col-12 col-md-6 mb-2">
            <form action="/teacher/ledgers" method="post" class="row g-1" id="searchLedger">
                @csrf
                <div class="col-6">
                    <select name="subject" class="form-select form-select-sm" id="subject">
                        @foreach($subjects as $score)
                        <option value="{{ $score->subject_id }}" data-send="{{ $score->subject_id }}" {{ selected(($table->subject_id ?? false) == $score->subject_id) }}>{{ $score->subject }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_grade" class="form-select form-select-sm" id="subGrade">
                        @foreach($subGrades as $score)
                        <option hidden value="{{ $score->sub_grade_id }}" subject="{{ $score->subject_id }}" {{ selected(($table->sub_grade_id ?? false) == $score->sub_grade_id) }}>{{ $score->subGrade }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="type" class="form-select form-select-sm" id="type">
                        <option hidden></option>
                        <option value="1" {{ selected(($table->type ?? false) == 1) }}>Pengetahuan</option>
                        <option value="2" {{ selected(($table->type ?? false) == 2) }}>Keterampilan</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if($table && session('ledger_' . request()->path()) == url()->current())
    <form action="/teacher/ledgers/load" method="post" id="ledger-load" data-show="1">
        @csrf
        <input type="hidden" name="subject" value="{{ $table->subject_id }}">
        <input type="hidden" name="sub_grade" value="{{ $table->sub_grade_id }}">
        <input type="hidden" name="type" value="{{ $table->type }}">
    </form>
    @endif

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card" id="ledgerTable">
        <div class="card-body"></div>
        {{-- Ledger --}}
    </div>

</section>

@push('scripts')
<script src="{{ asset('js/operator/ledgers.js') }}"></script>
@endpush

@endsection
