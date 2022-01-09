@extends('layout.template')

@section('content')
<div class="page-title">
    <h3>Beranda</h3>
    <p class="text-subtitle text-muted">Beranda guru bidang</p>
</div>
<hr>

<section class="section">
    <form action="/teacher/home" method="get" class="d-flex mb-2" id="search-home">
        <select name="subject" id="subject" class="form-select form-select-sm w-auto">
            @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ $selected['subject'] == $subject->id ? 'selected' : '' }}>{{ $subject->subject }}</option>
            @endforeach
        </select>
        <select name="subGrade" id="subGrade" class="form-select form-select-sm w-auto ms-2" onchange="this.form.submit()">
            @foreach($subGrades as $subGrade)
            <option value="{{ $subGrade->id }}" {{ $selected['subGrade'] == $subGrade->id ? 'selected' : '' }}>{{ $subGrade->sub_grade }}</option>
            @endforeach
        </select>
    </form>
    <div class="row g-2">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ketuntasan Kompetensi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th>KD</th>
                                    <th>Tuntas</th>
                                    <th>Tidak Tuntas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($finished as $competence => $finish)
                                <tr class="text-center">
                                    <td>{{ $competence }}</td>
                                    <td><strong class="text-success">{{ $finish['success'] }}</strong></td>
                                    <td><strong class="text-danger">{{ $finish['fail'] }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Diagram Kompetensi</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart" width="100" height="50" data-json="{{ $json }}"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="text-center">
                            <tr>
                                <th>Siswa</th>
                                @foreach($competences as $competence)
                                <th>{{ $competence }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recaps as $student => $recaps)
                            <tr>
                                <td>{!! $student !!}</td>
                                @foreach($recaps as $nilai)
                                <td class="text-center {{ $nilai['status'] ? '' : 'fw-bold text-danger' }}">{{ $nilai['nilai'] }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/teacher/home.js') }}"></script>
@endpush

@endsection
