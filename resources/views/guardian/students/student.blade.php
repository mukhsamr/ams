@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Siswa</h3>
    <p class="text-subtitle text-muted">Daftar lengkap siswa</p>
</div>

<hr>
<section class="section">
    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        @foreach($columns as $column)
                        <th>{{ Str::headline($column) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        @foreach($columns as $key => $column)
                        @if($key < 1) <td>{!! $student[$column] !!}</td>
                            @elseif($column == 'foto')
                            <td class="text-center">
                                @if(isset($student[$column]))
                                <a href="#img-{{ $key }}" data-bs-toggle="collapse"><i data-feather="eye"></i></a>
                                <div class="collapse" id="img-{{ $key }}">
                                    <img src="{{ asset('storage/img/students/' . $student[$column]) }}" alt="foto" width="100">
                                </div>
                                @endif
                            </td>
                            @else
                            <td>{{ $student[$column] }}</td>
                            @endif
                            @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>

@endsection
