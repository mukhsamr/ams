@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Catatan</h3>
    <p class="text-subtitle text-muted">Isian catatan siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">
    <form action="/guardian/notes" method="get" class="row g-1 mb-2">
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
    <x-alert-form action="/guardian/notes" message="Siswa perlu diperbaharui" :input="$check" name="student_version_id[]" />
    @endif

    <div class="card mt-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Panggilan</th>
                        <th>Catatan</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alpha</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td>{!! $note->nama !!}</td>
                        <td>{{ $note->called }}</td>
                        <td><span class="short">{{ $note->note }}</span></td>
                        <td class="text-center">{{ $attendances[$note->user_id]['Sakit'] ?? '-' }}</td>
                        <td class="text-center">{{ $attendances[$note->user_id]['Izin'] ?? '-' }}</td>
                        <td class="text-center">{{ $attendances[$note->user_id]['Alpha'] ?? '-' }}</td>
                        <td class="text-center">
                            <a href="/guardian/notes/edit/{{ $note->id }}" class="btn btn-info btn-sm load-modal" data-target="#edit"><i data-feather="edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $notes->links() }}
    <div id="modal"></div>
</section>

@endsection
