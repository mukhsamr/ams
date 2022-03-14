@extends('layout.template')

@section('content')

<section class="section">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-2">
                        <div class="d-flex">
                            <img src="{{ asset('storage/img/'.($user->foto ?? 'default.png').'') }}" class="rounded-circle img-thumbnail" id="preview" alt="preview" style="width: 150px; height: 150px; object-fit:cover;">
                        </div>
                    </div>
                    <div class="col-12 col-md-10">
                        <div class="row g-3">
                            <div class="col-12">
                                <h4 class="m-0">{{ $status ?? 'Pengajar' }}</h4 class="m-0">
                            </div>
                            <div class="col-12 col-md-3">
                                <strong>Mata Pelajaran :</strong>
                                <ul class="m-0">
                                    @foreach($subjects as $subject)
                                    <li>{{ $subject->subject }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-12 col-md-3">
                                <strong>Kelas :</strong>
                                <ul class="m-0">
                                    @foreach($subGrades as $subGrade)
                                    <li>{{ $subGrade->sub_grade }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Biodata</h4>
        </div>
        <div class="card-body">
            @foreach($user as $column => $value)
            @continue($column == 'foto')
            <div class="row g-0 mb-4 border-bottom">
                <div class="col-12 col-md-3">
                    <span>{{ Str::headline($column) }}</span>
                </div>
                <div class="col-12 col-md-9">
                    <strong class="fs-5">{!! $value ?? '-' !!}</strong>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
