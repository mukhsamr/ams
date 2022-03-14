@extends('layout.template')

@section('content')

<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    <div class="card">
        <div class="card-body">
            <form action="/setting" method="post" class="row" enctype="multipart/form-data">
                @csrf @method('put')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm" value="{{ $user->username }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-sm" minlength="5" required disabled>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="show">
                            <label class="form-check-label" for="show">
                                Tampilkan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="ignore" type="checkbox" id="ignore" checked>
                            <label class="form-check-label" for="ignore">
                                Abaikan
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm">
                        <div class="invalid-feedback">
                            Ukuran gambar terlalu besar
                        </div>
                        <div class="d-flex justify-content-between">
                            <small><em>Max size 1MB</em></small>
                            <small id="size"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <img src="{{ asset('storage/img/'.($user->foto ?? 'default.png').'') }}" class="rounded-circle img-thumbnail" id="preview" alt="preview" style="width: 150px; height: 150px; object-fit:cover;">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/user/setting.js') }}"></script>
@endpush

@endsection
