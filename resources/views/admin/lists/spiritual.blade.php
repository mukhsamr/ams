@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>List Spiritual</h3>
    <p class="text-subtitle text-muted">Daftar list spiritual wali kelas</p>
</div>
<hr>

<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <form action="{{ route('spiritual_store') }}" method="post" class="d-flex mb-2">
        @csrf
        <input type="text" name="list" class="form-control form-control-sm me-2" required>
        <button type="submit" class="btn btn-success btn-sm">
            <i data-feather="plus"></i>
        </button>
    </form>
    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>List</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spirituals as $spiritual)
                    <tr>
                        <td>{{ $spiritual->list }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit-{{ $spiritual->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('spiritual_delete', ['spiritual' => $spiritual->id]) }}"
                                method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus list?')">
                                    <i data-feather="trash"></i>
                                </button>
                            </form>
                        </td>
                        <div class="modal fade" id="edit-{{ $spiritual->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $spiritual->id }}Label"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('spiritual_put') }}" method="post">
                                        @csrf @method('put')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $spiritual->id }}Label">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $spiritual->id }}">
                                            <input type="text" name="list" class="form-control form-control-sm"
                                                value="{{ $spiritual->list }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary me-auto"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection