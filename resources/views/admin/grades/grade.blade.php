@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Kelas</h3>
    <p class="text-subtitle text-muted">Daftar Kelas</p>
</div>
<hr>
<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card mb-2">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="text-center">
                            <tr>
                                <th>Kelas</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                            <tr class="text-center">
                                <td>{{ $grade->grade }}</td>
                                <td>
                                    <form action="/grades/{{ $grade->id }}" method="post">
                                        @csrf @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas {{ $grade->grade }}')"><i data-feather="trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/grades" method="post">
                        @csrf
                        <label for="grade">Kelas</label>
                        <div class="d-flex justify-content-between">
                            <input type="number" name="grade" id="grade" class="form-control form-control-sm w-auto @error('grade') is-invalid @enderror" min="0" step="1" required>
                            @error('grade')
                            <div class="invalid-feedback my-auto ms-3">
                                {{ $message }}
                            </div>
                            @enderror
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
