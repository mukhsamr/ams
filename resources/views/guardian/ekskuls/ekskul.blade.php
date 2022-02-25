@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Ekskul</h3>
    <p class="text-subtitle text-muted">Isian ekskul siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>

<section class="section">
    <form action="/guardian/ekskuls" method="get" class="row g-1 mb-2">
        <div class="col-10 col-md-4">
            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Nama..." value="{{ $keyword }}">
        </div>
        <div class="col-2 col-md-2">
            <button type="submit" class="btn btn-dark btn-sm"><i data-feather="search"></i></button>
        </div>
    </form>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($check)
    <x-alert-form action="/guardian/ekskuls" message="Siswa perlu diperbaharui" :input="$check" name="student_version_id[]" />
    @endif

    <div class="card mt-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2">Nama</th>
                        <th colspan="2">Ekskul</th>
                        <th colspan="2">Ranah Afektif</th>
                        <th rowspan="2">Edit</th>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <th>Predikat</th>
                        <th>Jenis</th>
                        <th>Predikat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ekskuls as $ekskul)
                    <tr>
                        <td>{!! $ekskul->nama !!}</td>
                        <td>
                            <ul class="m-0">
                                @foreach(explode(',', $ekskul->ekskuls) as $list)
                                <li>{{ $list }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul class="m-0">
                                @foreach(explode(',', $ekskul->pre_e) as $pre)
                                <li>{{ $pre }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul class="m-0">
                                @foreach(explode(',', $ekskul->personalities) as $list)
                                <li>{{ $list }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul class="m-0">
                                @foreach(explode(',', $ekskul->pre_p) as $pre)
                                <li>{{ $pre }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            <a href="/guardian/ekskuls/edit/{{ $ekskul->id }}" class="btn btn-info btn-sm load-modal-ekskul" data-target="#edit"><i data-feather="edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<div id="modal"></div>
@endsection

@push('scripts')
<script src="{{ asset('js/guardian/ekskul.js') }}"></script>
@endpush
