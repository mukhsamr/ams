@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Siswa</h3>
    <p class="text-subtitle text-muted">Daftar siswa</p>
</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex">
            <form action="/daftar/students" method="get" id="search-student">
                <select name="subGrade" class="form-select form-select-sm w-auto" id="subGrade">
                    @foreach($subGrades as $subGrade)
                    <option value="{{ $subGrade->id }}" {{ $selected == $subGrade->id ? 'selected' : '' }}>{{ $subGrade->sub_grade }}</option>
                    @endforeach
                </select>
            </form>

            <input type="text" id="search" class="form-control form-control-sm w-auto ms-2" placeholder="Cari...">
        </div>

        <form action="/daftar/students/create/{{ $selected }}">
            <button type="submit" class="btn btn-secondary btn-sm"><i data-feather="plus"></i></button>
        </form>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    <em><strong id="jumlah">{{ count($students) }}</strong> siswa</em>
    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{!! $student->student->nama !!}</td>
                        <td class="text-center">{{ $student->subGrade->sub_grade }}</td>
                        <td class="text-center">
                            <form action="/daftar/students/{{ $student->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data {!! $student->student->nama !!} akan dihapus!')"><i data-feather="trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/operator/students.js') }}"></script>
@endpush

@endsection