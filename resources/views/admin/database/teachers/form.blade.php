@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Form Guru</h3>
    <p class="text-subtitle text-muted">Form isian data lengkap guru</p>
</div>
<hr>
<section class="section">
    <div class="d-flex justify-content-between mb-2">
        <a href="/database/teachers" class="btn btn-dark btn-sm"><i data-feather="arrow-left"></i></a>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card mb-2">
        <div class="card-header">
            <h4>Form {{ $method == 'post' ? 'Tambah' : 'Edit' }} Guru</h4>
        </div>
        <div class="card-body">
            <form action="/database/teachers" method="post" enctype="multipart/form-data">
                @csrf
                @if($method == 'put')
                @method('put')
                <input type="hidden" name="id" value="{{ $teacher->id }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="nama" class="form-label">Nama <strong class="text-danger">*</strong></label>
                        <input type="text" name="nama" class="form-control form-control-sm" id="nama" value="{{ (isset($teacher->nama) ? str_replace('&nbsp;', ' ', $teacher->nama) : false) ?? old('nama') }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" value="{{ $teacher->email ?? old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_telp" class="form-label">Nomor HP</label>
                        <input type="number" name="no_telp" class="form-control form-control-sm" value="{{ $teacher->no_telp ?? old('no_telp') }}" id="no_telp">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_rek" class="form-label">Nomor Rekening</label>
                        <input type="text" name="no_rek" class="form-control form-control-sm" value="{{ $teacher->no_rek ?? old('no_rek') }}" id="no_rek">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_ktp" class="form-label">Nomor KTP</label>
                        <input type="text" name="no_ktp" class="form-control form-control-sm @error('no_ktp') is-invalid @enderror" value="{{ $teacher->no_ktp ?? old('no_ktp') }}" id="no_rek">
                        @error('no_ktp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="kota_lahir" class="form-label">Kota Lahir</label>
                        <input type="text" name="kota_lahir" class="form-control form-control-sm" value="{{ $teacher->kota_lahir ?? old('kota_lahir') }}" id="no_rek">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control form-control-sm" value="{{ $teacher->tanggal_lahir ?? old('tanggal_lahir') }}" id="no_rek">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="jk" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jk" class="form-select form-select-sm">
                            <option value="L" {{ (($teacher->jenis_kelamin ?? null) == 'L' ?? old('jenis_kelamin')) ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ (($teacher->jenis_kelamin ?? null) == 'P' ?? old('jenis_kelamin')) ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="alamat_ktp" class="form-label">Alamat KTP</label>
                        <input type="text" name="alamat_ktp" class="form-control form-control-sm" id="alamat_ktp" value="{{ $teacher->alamat_ktp ?? old('alamat_ktp') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                        <input type="text" name="alamat_domisili" class="form-control form-control-sm" id="alamat_domisili" value="{{ $teacher->alamat_domisili ?? old('alamat_domisili') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="gol_darah" class="form-label">Golongan Darah</label>
                        <input type="text" name="gol_darah" class="form-control form-control-sm" id="gol_darah" value="{{ $teacher->gol_darah ?? old('gol_darah') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="status_nikah" class="form-label">Status Nikah</label>
                        <select name="status_nikah" class="form-select form-select-sm" id="status_nikah">
                            <option value="Belum Menikah" {{ (($teacher->status_nikah ?? null) == 'Belum Menikah' ?? old('status_nikah')) ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Sudah Menikah" {{ (($teacher->status_nikah ?? null) == 'Sudah Menikah' ?? old('status_nikah')) ? 'selected' : '' }}>Sudah Menikah</option>
                            <option value="Janda" {{ (($teacher->status_nikah ?? null) == 'Janda' ?? old('status_nikah')) ? 'selected' : '' }}>Janda</option>
                            <option value="Duda" {{ (($teacher->status_nikah ?? null) == 'Duda' ?? old('status_nikah')) ? 'selected' : '' }}>Duda</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_kk" class="form-label">Nomor KK</label>
                        <input type="text" name="no_kk" class="form-control form-control-sm" id="no_kk" value="{{ $teacher->no_kk ?? old('no_kk') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="nama_pasangan" class="form-label">Nama Pasangan</label>
                        <input type="text" name="nama_pasangan" class="form-control form-control-sm" id="nama_pasangan" value="{{ $teacher->nama_pasangan ?? old('nama_pasangan') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="pekerjaan_pasangan" class="form-label">Pekerjaan Pasangan</label>
                        <input type="text" name="pekerjaan_pasangan" class="form-control form-control-sm" id="pekerjaan_pasangan" value="{{ $teacher->pekerjaan_pasangan ?? old('nama_pasangan') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="tempat_bekerja_pasangan" class="form-label">Tempat Bekerja Pasangan</label>
                        <input type="text" name="tempat_bekerja_pasangan" class="form-control form-control-sm" id="tempat_bekerja_pasangan" value="{{ $teacher->tempat_bekerja_pasangan ?? old('nama_pasangan') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
                        <input type="number" name="jumlah_anak" class="form-control form-control-sm" id="jumlah_anak" value="{{ $teacher->jumlah_anak ?? old('nama_pasangan') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control form-control-sm" id="nama_wali" value="{{ $teacher->nama_wali ?? old('nama_wali') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="status_wali" class="form-label">Status Wali</label>
                        <input type="text" name="status_wali" class="form-control form-control-sm" id="status_wali" value="{{ $teacher->status_wali ?? old('status_wali') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_telp_wali" class="form-label">No Telp Wali</label>
                        <input type="number" name="no_telp_wali" class="form-control form-control-sm" id="no_telp_wali" value="{{ $teacher->no_telp_wali ?? old('no_telp_wali') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="ibu_kandung" class="form-label">Ibu Kandung</label>
                        <input type="text" name="ibu_kandung" class="form-control form-control-sm" id="ibu_kandung" value="{{ $teacher->ibu_kandung ?? old('ibu_kandung') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" class="form-control form-control-sm" id="pendidikan_terakhir" value="{{ $teacher->pendidikan_terakhir ?? old('pendidikan_terakhir') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="institusi_lulusan" class="form-label">Institusi Lulusan</label>
                        <input type="text" name="institusi_lulusan" class="form-control form-control-sm" id="institusi_lulusan" value="{{ $teacher->institusi_lulusan ?? old('institusi_lulusan') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="program_studi" class="form-label">Program Studi</label>
                        <input type="text" name="program_studi" class="form-control form-control-sm" id="program_studi" value="{{ $teacher->program_studi ?? old('program_studi') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" class="form-control form-control-sm" id="tahun_lulus" value="{{ $teacher->tahun_lulus ?? old('tahun_lulus') }}" min="1000">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="mulai_bekerja" class="form-label">Mulai Bekerja</label>
                        <input type="date" name="mulai_bekerja" class="form-control form-control-sm" id="mulai_bekerja" value="{{ $teacher->mulai_bekerja ?? old('mulai_bekerja') }}" min="1000">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="status_keryawan" class="form-label">Status Karyawan</label>
                        <select name="status_karyawan" class="form-select form-select-sm" id="status_karyawan">
                            <option value="Kontrak" {{ (($teacher->status_karyawan ?? null) == 'Kontrak' ?? old('status_karyawan')) ? 'selected' : '' }}>Kontrak</option>
                            <option value="Tetap" {{ (($teacher->status_karyawan ?? null) == 'Tetap' ?? old('status_karyawan')) ? 'selected' : '' }}>Tetap</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_bpjs_kesehatan" class="form-label">No BPJS Kesehatan</label>
                        <input type="text" name="no_bpjs_kesehatan" class="form-control form-control-sm" id="no_bpjs_kesehatan" value="{{ $teacher->no_bpjs_kesehatan ?? old('no_bpjs_kesehatan') }}" min="1000">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="no_bpjs_ketenagakerjaan" class="form-label">No BPJS Ketenagakerjaan</label>
                        <input type="text" name="no_bpjs_ketenagakerjaan" class="form-control form-control-sm" id="no_bpjs_ketenagakerjaan" value="{{ $teacher->no_bpjs_ketenagakerjaan ?? old('no_bpjs_ketenagakerjaan') }}" min="1000">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="npwp" class="form-label">NPWP</label>
                        <input type="text" name="npwp" class="form-control form-control-sm" id="npwp" value="{{ $teacher->npwp ?? old('npwp') }}" min="1000">
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
                        <img src="{{ isset($teacher->foto) ? asset('storage/img/teachers/' . $teacher->foto) : asset('storage/img/default.png') }}" id="preview" class="img-thumbnail" alt="foto" width="150">
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
