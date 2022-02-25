@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Edit Siswa</h3>
    <p class="text-subtitle text-muted">Daftarkan siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">

    <div class="d-flex justify-content-between mb-2">
        <input type="text" id="search" class="form-control form-control-sm w-auto" placeholder="Cari...">
        <a href="/daftar/students?subGrade={{ $subGrade->id }}" class="btn btn-dark btn-sm"><i data-feather="arrow-left"></i></a>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    <em><strong id="jumlah">{{ count($students) }}</strong> siswa</em>
    <form action="/daftar/students" method="post">
        <input type="hidden" name="sub_grade_id" value="{{ $subGrade->id }}">
        <div class="card mb-2">
            <div class="table-responsive" style="max-height: 80vh">
                <table class="table table-bordered mb-0">
                    <thead class="text-center">
                        <tr>
                            <th>
                                <input class="form-check-input" type="checkbox" id="all">
                            </th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td class="text-center">
                                @csrf
                                <input name="student_id[]" class="form-check-input" type="checkbox" value="{{ $student->id }}">
                            </td>
                            <td>{!! $student->nama !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
    </form>

</section>

@push('scripts')
<script src="{{ asset('js/operator/students.js') }}"></script>
@endpush

@endsection
