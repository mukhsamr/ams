@extends('layout.template')

@section('content')

@php
$table = session(request()->path());
@endphp

<div class="page-title">
    <h3>Ledger</h3>
    <p class="text-subtitle text-muted">Rekap nilai harian <strong>{{ $subGrade->sub_grade }}</strong>.</p>
</div>

<hr>
<section class="section">
    <form action="/teacher/ledgers" method="post" class="row g-1 mb-2" id="searchLedger">
        @csrf
        <div class="col-6 col-md-4">
            <select name="subject" class="form-select form-select-sm" id="subject-search">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ selected(($table->subject_id ?? false) == $subject->id)}}>{{ $subject->subject }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="sub_grade" value="{{ $subGrade->id }}">
        <div class="col-6 col-md-2">
            <select name="type" class="form-select form-select-sm" id="type-search">
                <option hidden></option>
                <option value="1" {{ selected(($table->type ?? false) == 1) }}>Pengetahuan</option>
                <option value="2" {{ selected(($table->type ?? false) == 2) }}>Keterampilan</option>
            </select>
        </div>
    </form>

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
<script src="{{ asset('js/guardian/ledgers.js') }}"></script>
@endpush

@endsection
