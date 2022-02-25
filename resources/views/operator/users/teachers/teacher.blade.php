@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Akun Guru</h3>
    <p class="text-subtitle text-muted">Daftar akun guru</p>
</div>

<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/user/teacher" class="row g-1">
                <div class="col-10">
                    <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Nama..." value="{{ $keyword }}">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-sm btn-dark"><i data-feather="search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-0 text-md-end">
            <a href="/user/teacher/create" class="btn btn-sm btn-success load-modal-user" data-target="#create"><i data-feather="plus"></i></a>
        </div>
    </div>


    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{!! $user->nama !!}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->status }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="text-center">
                            <a href="/user/teacher/edit/{{ $user->id }}" class="btn btn-sm btn-info load-modal-user" data-target="#edit"><i data-feather="edit"></i></a>
                        </td>
                        <td class="text-center">
                            <form action="/user/{{ $user->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user {!! $user->nama !!}')"><i data-feather="trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links() }}
    {{-- modal --}}
    <div id="modal"></div>

</section>

@push('scripts')
<script src="{{ asset('js/operator/users.js') }}"></script>
@endpush

@endsection
