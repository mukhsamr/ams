@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Ledger</h3>
    <p class="text-subtitle text-muted">Rekap nilai harian <strong>{{ $subGrade->sub_grade }}</strong>.</p>

</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-2">
        <form action="/teacher/ledgers" method="post" class="d-flex" id="searchLedger">
            @csrf
            <select name="subject" class="form-select form-select-sm w-auto" id="subject">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" data-send="{{ $subject->id }}" {{ (session(request()->path())->subject_id ?? false) == $subject->id ? 'selected' : '' }}>{{ $subject->subject }}</option>
                @endforeach
            </select>
            <input type="hidden" name="sub_grade" value="{{ $subGrade->id }}">
            <select name="type" class="form-select form-select-sm w-auto ms-1" id="type">
                <option hidden></option>
                <option value="1" {{ (session(request()->path())->type ?? false) == 1 ? 'selected' : '' }}>Pengetahuan</option>
                <option value="2" {{ (session(request()->path())->type ?? false) == 2 ? 'selected' : '' }}>Keterampilan</option>
            </select>
        </form>
    </div>

    @if(($ledger = session(request()->path())) && session('ledger_' . request()->path()) == url()->current())
    <form action="/teacher/ledgers/load" method="post" id="ledger-load" data-show="1">
        @csrf
        <input type="hidden" name="subject" value="{{ $ledger->subject_id }}">
        <input type="hidden" name="sub_grade" value="{{ $ledger->sub_grade_id }}">
        <input type="hidden" name="type" value="{{ $ledger->type }}">
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
