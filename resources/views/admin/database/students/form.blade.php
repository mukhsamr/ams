@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Form Siswa</h3>
    <p class="text-subtitle text-muted">Form isian data lengkap siswa</p>
</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-2">
        <a href="/database/students" class="btn btn-dark btn-sm"><i data-feather="arrow-left"></i></a>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card mb-2">
        <div class="card-header">
            <h4>Form {{ $method == 'post' ? 'Tambah' : 'Edit' }} Siswa</h4>
        </div>
        <div class="card-body">
            <form action="/database/students" method="post" enctype="multipart/form-data">
                @csrf
                @if($method == 'put')
                @method('put')
                <input type="hidden" name="id" value="{{ $student->id }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="nama" class="form-label">Nama <strong class="text-danger">*</strong></label>
                        <input type="text" name="nama" class="form-control form-control-sm" id="nama" value="{{ (isset($student->nama) ? str_replace('&nbsp;', ' ', $student->nama) : false) ?? old('nama') }}" required>


                    </div>
                    <div class="col-12 col-md-4">
                        <label for="nipd" class="form-label">NIPD <strong class="text-danger">*</strong></label>
                        <input type="number" name="nipd" class="form-control form-control-sm @error('nipd') is-invalid @enderror" id="nipd" value="{{ $student->nipd ?? old('nipd') }}" required>

                        @error('nipd')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="nisn" class="form-label">NISN <strong class="text-danger">*</strong></label>
                        <input type="number" name="nisn" class="form-control form-control-sm @error('nisn') is-invalid @enderror" value="{{ $student->nisn ?? old('nisn') }}" id="nisn" required>

                        @error('nisn')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="jk" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jk" class="form-select form-select-sm">
                            <option value="L" {{ (($student->jenis_kelamin ?? null) == 'L' ?? old('jenis_kelamin')) ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ (($student->jenis_kelamin ?? null) == 'P' ?? old('jenis_kelamin')) ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control form-control-sm" id="tempat_lahir" value="{{ $student->tempat_lahir ?? old('tempat_lahir') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control form-control-sm" id="tanggal_lahir" max="{{ date('Y-m-d') }}" value="{{ $student->tanggal_lahir ?? old('tanggal_lahir') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="agama" class="form-label">Agama</label>
                        <input type="text" name="agama" class="form-control form-control-sm" id="agama" value="{{ $student->agama ?? old('agama') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control form-control-sm" id="alamat" value="{{ $student->alamat ?? old('alamat') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="dusun" class="form-label">Dusun</label>
                        <input type="text" name="dusun" class="form-control form-control-sm" id="dusun" value="{{ $student->dusun ?? old('dusun') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="kecamatan" class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control form-control-sm" id="kelurahan" value="{{ $student->kelurahan ?? old('kelurahan') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control form-control-sm" id="kecamatan" value="{{ $student->kecamatan ?? old('kecamatan') }}">
                    </div>
                    <div class="col-6 col-md-2">
                        <label for="rt" class="form-label">RT</label>
                        <input type="number" name="rt" class="form-control form-control-sm" id="rt" value="{{ $student->rt ?? old('rt') }}">
                    </div>
                    <div class="col-6 col-md-2">
                        <label for="rw" class="form-label">RW</label>
                        <input type="number" name="rw" class="form-control form-control-sm" id="rw" value="{{ $student->rw ?? old('rw') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="number" name="kode_pos" class="form-control form-control-sm" id="kode_pos" value="{{ $student->kode_pos ?? old('kode_pos') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input type="number" name="no_hp" class="form-control form-control-sm" id="no_hp" value="{{ $student->no_hp ?? old('no_hp') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="anak_ke" class="form-label">Anak ke</label>
                        <input type="number" name="anak_ke" class="form-control form-control-sm" id="anak_ke" value="{{ $student->anak_ke ?? old('anak_ke') }}">
                    </div>
                </div>
                <div class="divider divider-left">
                    <div class="divider-text"><strong>Ayah</strong></div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control form-control-sm" id="nama_ayah" value="{{ $student->nama_ayah ?? old('nama_ayah') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control form-control-sm" id="pekerjaan_ayah" value="{{ $student->pekerjaan_ayah ?? old('pekerjaan_ayah') }}">
                    </div>
                </div>
                <div class="divider divider-left">
                    <div class="divider-text"><strong>Ibu</strong></div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control form-control-sm" id="nama_ibu" value="{{ $student->nama_ibu ?? old('nama_ibu') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control form-control-sm" id="pekerjaan_ibu" value="{{ $student->pekerjaan_ibu ?? old('pekerjaan_ibu') }}">
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-12 col-md-4">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-control form-control-sm @error('file') is-invalid @enderror" id="foto" accept="image/*">
                        @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <small><em>Max size 1 Mb</em></small>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="preview" class="d-block form-label">Preview</label>
                        <img src="{{ isset($student->foto) ? asset('storage/img/students/' . $student->foto) : asset('storage/img/default.png') }}" id="preview" class="img-thumbnail" alt="foto" width="150">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Simpan</button>
            </form>
        </div>
    </div>

    </div>

</section>

@push('scripts')
<script src="{{ asset('js/database.js') }}"></script>
@endpush

@endsection
