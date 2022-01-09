@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Harian</h3>
    <p class="text-subtitle text-muted">Penilaian harian siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-3">
        <form action="/teacher/scores/search" method="get" class="d-flex" id="search-score">
            <input type="hidden" name="sub_grade" value="{{ $subGrade->id }}">
            <select name="subject" class="form-select form-select-sm w-auto" id="subject" required>
                <option hidden></option>
                @foreach($subjects as $subject)
                <option data-send="{{ $subject->id }}" value="{{ $subject->id }}" {{ (session(request()->path())->subject_id ?? false) == $subject->id ? 'selected' : '' }}>
                    {{ $subject->subject }}
                </option>
                @endforeach
            </select>
            <select name="competence" class="form-select form-select-sm w-auto ms-2" id="competence" required>
                <option hidden></option>
                @foreach($competences as $competence)
                <option hidden value="{{ $competence->id }}" data-subject="{{ $competence->subject_id }}" {{ (session(request()->path())->competence_id ?? false) == $competence->id ? 'selected' : '' }}>
                    {{ $competence->format_competence }}
                </option>
                @endforeach
            </select>
        </form>

        @if(($table = session(request()->path())) && session('score_' . request()->path()) == url()->current())
        <form action="/teacher/scores/show" method="post" id="score-show" data-show="1">
            @csrf
            <input type="hidden" name="name" value="{{ $table->name }}">
            <input type="hidden" name="subject_id" value="{{ $table->subject_id }}">
            <input type="hidden" name="sub_grade_id" value="{{ $table->sub_grade_id }}">
            <input type="hidden" name="competence_id" value="{{ $table->competence_id }}">
        </form>
        @endif
    </div>

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
