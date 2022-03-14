@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Sosial</h3>
    <p class="text-subtitle text-muted">Isian social siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>

<section class="section">
    <form action="/guardian/socials" method="get" class="row g-1 mb-2">
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
    <x-alert-form action="/guardian/socials" message="Siswa perlu diperbaharui" :input="$check" name="student_version_id[]" />
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
                    @foreach($socials as $social)
                    <tr>
                        <td>{!! $social->nama !!}</td>
                        <td>
                            <ul class="m-0">
                                @foreach(explode(',', $social->socials) as $list)
                                <li>{{ $list }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $social->social }}</td>
                        <td><span class="short">{{ $social->comment }}</span></td>
                        <td class="text-center">{{ $social->predicate }}</td>
                        <td class="text-center">
                            <a href="/guardian/socials/edit/{{ $social->id }}" class="btn btn-info btn-sm load-modal-social" data-target="#edit"><i data-feather="edit"></i></a>
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
<script src="{{ asset('js/guardian/social.js') }}"></script>
@endpush
