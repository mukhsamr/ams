@extends('layout.template')

@section('content')

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
        <div class="col-12 col-md-6 order-1 text-md-end">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-score" id="btn-float">
                <i data-feather="plus"></i>
            </button>

            <div class="modal fade" id="add-score" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-scoreLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/teacher/scores" method="post">
                            @csrf
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white" id="add-scoreLabel">Tambah nilai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="subject">Pelajaran</label>
                                            <select name="subject" class="form-select form-select-sm" id="add-subject" required>
                                                @foreach ($user->subject as $subject)
                                                <option value="{{ $subject->id }}" data-send="{{ $subject->id }}">{{ $subject->subject }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="form-group">
                                            <label for="sub_grade">Kelas</label>
                                            <select name="sub_grade" class="form-select form-select-sm" id="add-subGrade" required>
                                                <option hidden></option>
                                                @foreach ($user->subGrade as $subGrade)
                                                <option value="{{ $subGrade->id }}" data-send="{{ $subGrade->grade->id }}">{{ $subGrade->sub_grade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="form-group">
                                            <label for="competence">Kompetensi</label>
                                            <select name="competence" class="form-select form-select-sm" id="add-competence" required>
                                                <option hidden></option>
                                                @foreach ($user->competence as $competence)
                                                <option hidden value="{{ $competence->id }}" data-grade="{{ $competence->subject_id.'-'.$competence->grade->id }}" data-summary="{{ $competence->summary }}">{{ $competence->format_competence }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="summary">Ringkasan</label>
                                            <textarea class="form-control" id="summary" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
<script src="{{ asset('js/scores.js') }}"></script>
@endpush

@endsection
