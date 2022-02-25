@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Spiritual</h3>
    <p class="text-subtitle text-muted">Isian spiritual siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">
    <form action="/guardian/spirituals" method="get" class="row g-1 mb-2">
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
    <x-alert-form action="/guardian/spirituals" message="Siswa perlu diperbaharui" :input="$check" name="student_version_id[]" />
    @endif

    <div class="card mt-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Sikap selalu dilakukan</th>
                        <th>Sikap sudah menunjukan</th>
                        <th>Komentar</th>
                        <th>Predikat</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spirituals as $spiritual)
                    <tr>
                        <td>{!! $spiritual->nama !!}</td>
                        <td>
                            <ul class="m-0">
                                @foreach(explode(',', $spiritual->spirituals) as $list)
                                <li>{{ $list }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $spiritual->spiritual }}</td>
                        <td><span class="short">{{ $spiritual->comment }}</span></td>
                        <td class="text-center">{{ $spiritual->predicate }}</td>
                        <td class="text-center">
                            <a href="/guardian/spirituals/edit/{{ $spiritual->id }}" class="btn btn-info btn-sm load-modal-spiritual" data-target="#edit"><i data-feather="edit"></i></a>
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
<script src="{{ asset('js/guardian/spiritual.js') }}"></script>
@endpush
