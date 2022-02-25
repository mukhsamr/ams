@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>List Social</h3>
    <p class="text-subtitle text-muted">Daftar list social wali kelas</p>
</div>
<hr>

<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <form action="{{ route('social_store') }}" method="post" class="d-flex mb-2">
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
                    @foreach ($socials as $social)
                    <tr>
                        <td>{{ $social->list }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit-{{ $social->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('social_delete', ['social' => $social->id]) }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus list?')">
                                    <i data-feather="trash"></i>
                                </button>
                            </form>
                        </td>
                        <div class="modal fade" id="edit-{{ $social->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $social->id }}Label"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('social_put') }}" method="post">
                                        @csrf @method('put')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $social->id }}Label">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $social->id }}">
                                            <input type="text" name="list" class="form-control form-control-sm"
                                                value="{{ $social->list }}" required>
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