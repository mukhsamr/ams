@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Harian</h3>
    <p class="text-subtitle text-muted">Penilaian harian siswa</p>
</div>
<hr>
<section class="section">
    <div class="row mb-2">
        <div class="col12 col-md-6">
            <form action="/teacher/scores/search" method="get" class="row g-1" id="search-score">
                <div class="col-6">
                    <select name="subject" class="form-select form-select-sm form-select form-select-sm-sm" id="subject" required>
                        @foreach($subjects as $subject)
                        <option data-send="{{ $subject->subject_id }}" value="{{ $subject->subject_id }}" {{ (session(request()->path())->subject_id ?? false) == $subject->subject_id ? 'selected' : '' }}>
                            {{ $subject->subject->subject }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_grade" class="form-select form-select-sm form-select form-select-sm-sm" id="sub_grade" required>
                        <option hidden></option>
                        @foreach($subGrades as $subGrade)
                        <option hidden data-subject="{{ $subGrade->subject_id }}" data-send="{{ $subGrade->sub_grade_id.'_'.$subGrade->subject_id }}" value="{{ $subGrade->sub_grade_id }}" {{ ((session(request()->path())->sub_grade_id ?? false) == $subGrade->sub_grade_id && (session(request()->path())->subject_id ?? false) == $subGrade->subject_id) ? 'selected' : '' }}>
                            {{ $subGrade->subGrade->sub_grade }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="competence" class="form-select form-select-sm form-select form-select-sm-sm" id="competence" required>
                        <option hidden></option>
                        @foreach($competences as $competence)
                        <option hidden data-subject_sub_grade="{{ $competence->sub_grade_id.'_'.$competence->subject_id }}" value="{{ $competence->competence_id }}" {{ (session(request()->path())->competence_id ?? false) == $competence->competence_id ? 'selected' : '' }}>
                            {{ $competence->competence->format_competence }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
    @if(($table = session(request()->path())) && session('score_' . request()->path()) == url()->current())
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
<script src="{{ asset('js/operator/scores.js') }}"></script>
@endpush

@endsection
