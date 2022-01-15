@extends('layout.template')

@section('content')

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
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->subject_id }}" data-send="{{ $subject->subject_id }}" {{ (session(request()->path())->subject_id ?? false) == $subject->subject_id ? 'selected' : '' }}>{{ $subject->subject->subject }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_grade" class="form-select form-select-sm" id="subGrade">
                        @foreach($subGrades as $subGrade)
                        <option hidden value="{{ $subGrade->sub_grade_id }}" data-subject="{{ $subGrade->subject_id }}" {{ (session(request()->path())->sub_grade_id ?? false) == $subGrade->sub_grade_id ? 'selected' : '' }}>{{ $subGrade->subGrade->sub_grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="type" class="form-select form-select-sm" id="type">
                        <option hidden></option>
                        <option value="1" {{ (session(request()->path())->type ?? false) == 1 ? 'selected' : '' }}>Pengetahuan</option>
                        <option value="2" {{ (session(request()->path())->type ?? false) == 2 ? 'selected' : '' }}>Keterampilan</option>
                    </select>
                </div>
            </form>
        </div>
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
<script src="{{ asset('js/ledgers.js') }}"></script>
@endpush

@endsection
