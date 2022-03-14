@extends('layout.template')

@section('content')

@php
$table = session(request()->path());
@endphp

<div class="page-title">
    <h3>Harian</h3>
    <p class="text-subtitle text-muted">Penilaian harian siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">
    <form action="/teacher/scores/search" method="get" class="row g-1 mb-2" id="search-score">
        <div class="col-8 col-md-4">
            <input type="hidden" name="sub_grade" value="{{ $subGrade->id }}">
            <select name="subject" class="form-select form-select-sm" id="subject-search" required>
                <option hidden></option>
                @foreach($subjects as $subject)
                <option data-subject="{{ $subject->id }}" value="{{ $subject->id }}" {{ selected(($table->subject_id ?? false) == $subject->id) }}>
                    {{ $subject->subject }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-4 col-md-2">
            <select name="competence" class="form-select form-select-sm" id="competence-search" required>
                <option hidden></option>
                @foreach($competences as $competence)
                <option hidden value="{{ $competence->id }}" subject="{{ $competence->subject_id }}" {{ selected(($table->competence_id ?? false) == $competence->id) }}>
                    {{ $competence->format_competence }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($table && session('score_' . request()->path()) == url()->current())
    <form action="/teacher/scores/show" method="post" id="score-show" data-show="1">
        @csrf
        <input type="hidden" name="name" value="{{ $table->name }}">
        <input type="hidden" name="subject_id" value="{{ $table->subject_id }}">
        <input type="hidden" name="sub_grade_id" value="{{ $table->sub_grade_id }}">
        <input type="hidden" name="competence_id" value="{{ $table->competence_id }}">
    </form>
    @endif

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" warning="Nilai sudah ada." />
    @endif

    <div class="card" id="score-table">
        <div class="card-body"></div>
        {{-- Score --}}
    </div>

</section>

@push('scripts')
<script src="{{ asset('js/guardian/scores.js') }}"></script>
@endpush

@endsection
