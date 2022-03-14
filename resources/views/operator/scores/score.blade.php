@extends('layout.template')

@section('content')

@php
$table = session(request()->path());
@endphp

<div class="page-title">
    <h3>Harian</h3>
    <p class="text-subtitle text-muted">Penilaian harian siswa</p>
</div>
<hr>

<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/teacher/scores/search" method="get" class="row g-1" id="search-score">
                <div class="col-6">
                    <select name="subject" class="form-select form-select-sm" id="subject" required>
                        @foreach($subjects as $score)
                        <option value="{{ $score->subject_id }}" data-subject="{{ $score->subject_id }}" {{ selected(($table->subject_id ?? null) == $score->subject_id) }}>
                            {{ $score->subject }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_grade" class="form-select form-select-sm" id="subGrade" required>
                        <option hidden></option>
                        @foreach($subGrades as $score)
                        <option hidden value="{{ $score->sub_grade_id }}" subject="{{ $score->subject_id }}" data-subgrade="{{ $score->sub_grade_id }}" {{ selected(($table->sub_grade_id ?? null) == $score->sub_grade_id) }}>
                            {{ $score->subGrade }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="competence" class="form-select form-select-sm" id="competence" required>
                        <option hidden></option>
                        @foreach($competences as $score)
                        <option hidden value="{{ $score->competence_id }}" subject="{{ $score->subject_id }}" subgrade="{{ $score->sub_grade_id }}" {{ selected(($table->competence_id ?? null) == $score->competence_id) }}>
                            {{ competence($score) }}
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
        </div>
        <div class="col-12 col-md-6 order-1 text-md-end">
            <a href="/teacher/scores/create" class="btn btn-success btn-sm modal-competence" data-target="#create"><i data-feather="plus"></i></a>
        </div>

    </div>

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card" id="score-table">
        <div class="card-body"></div>
        {{-- Score --}}
    </div>

    <div id="modal"></div>
</section>

@push('scripts')
<script src="{{ asset('js/operator/scores.js') }}"></script>
@endpush

@endsection
