@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>K13</h3>
    <p class="text-subtitle text-muted">Raport K13 kelas <strong>{{ $subGrade->sub_grade ?? null }}</strong></p>
</div>
<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/operator/raports/k13" class="row g-1">
                <div class="col-10 col-md-7 d-flex">
                    <select name="subGrade" id="subGrade" class="form-select form-select-sm w-auto" required
                        onchange="this.form.submit()">
                        @foreach ($subGrades as $sub_grade)
                        <option value="{{ $sub_grade->id }}" {{ selected($sub_grade->id == $selected) }}>{{
                            $sub_grade->sub_grade }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama" id="nama" required>
                    <input class="form-control form-control-sm" list="listNama" id="student" placeholder="Nama..."
                        required value="{{ $student }}">
                    <datalist id="listNama">
                        @foreach($students as $student) <option data-id="{{ $student->student_id }}"
                            value="{!! $student->nama !!}"> @endforeach
                    </datalist>
                </div>
                <div class="col-2 col-md-3">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i data-feather="search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 orser-md-0 text-md-end">
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#setting">
                <i data-feather="settings"></i>
            </button>
            <form action="{{ route('raport_k13_pdf') }}" method="post" class="d-inline-flex">
                @csrf
                <input type="hidden" name="type" value="k13">
                <input type="hidden" name="nama" value="{{ $nama }}">
                <input type="hidden" name="subGrade" value="{{ $subGrade->id ?? null }}">
                <button type="submit" class="btn btn-sm btn-danger" {{ @disabled(!$nama) }}>PDF</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="settingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('raport_setting') }}" method="post">
                    @csrf @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingLabel">Setelan Raport</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="k13">
                        <div class="form-group">
                            <label for="place">Tempat, waktu</label>
                            <input type="text" name="place" class="form-control form-control-sm" placeholder="..."
                                value="{{ $setting->place }}" required>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="background" value="1"
                                    role="switch" id="background" {{ checked($setting->background) }}>
                                <label class="form-check-label" for="background">Background</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card">
        <div class="card-body">
            <h5>A. SIKAP</h5>
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nilai</th>
                            <th>Predikat</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sikap as $type => $skp)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $type }}</td>
                            <td class="text-center">{{ $skp->predicate ?? '-' }}</td>
                            <td><span class="short">{{ $skp ? "Ananda $skp->called $skp->comment" : '-' }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h5>B. PENGETAHUAN</h5>
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>KKM</th>
                            <th>Nilai</th>
                            <th>Predikat</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengetahuan as $local)
                        @foreach($local as $subject => $png)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $subject }}</td>
                            <td class="text-center">{{ $png->kkm ?? $png['kkm'] ?? '-' }}</td>
                            <td class="text-center">{{ $png->hpa ?? $png['hpa'] ?? '-' }}</td>
                            <td class="text-center">{!! $png->format_pre ?? '-' !!}</td>
                            <td><span class="short">{{ $png ? "Ananda $png->called $png->deskripsi" : '-' }}</span></td>
                        </tr>
                        @endforeach
                        @if ($loop->first)
                        <tr>
                            <th colspan="6">Muatan Lokal</th>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h5>C. KETERAMPILAN</h5>
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>KKM</th>
                            <th>Nilai</th>
                            <th>Predikat</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keterampilan as $local)
                        @foreach($local as $subject => $ktr)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $subject }}</td>
                            <td class="text-center">{{ $ktr->kkm }}</td>
                            <td class="text-center">{{ $ktr->rph }}</td>
                            <td class="text-center">{!! $ktr->format_pre ?? '-' !!}</td>
                            <td><span class="short">{{ $ktr ? "Ananda $ktr->called $ktr->deskripsi" : '-' }}</span></td>
                        </tr>
                        @endforeach
                        @if ($loop->first)
                        <tr>
                            <th colspan="6">Muatan Lokal</th>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>Kegiatan Pengembangan Diri</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ekskul as $eks)
                                <tr>
                                    <th class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ $eks->list }}</td>
                                    <td class="text-center">{{ $eks->pivot->predicate }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Catatan Kehadiran</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Alasan</th>
                                    <th>Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absen as $status => $abs)
                                <tr>
                                    <th class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ $status }}</td>
                                    <td class="text-center">{{ $abs ? $abs->count : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h5>Catatan Guru Wali Kelas</h5>
            <div class="border py-2 px-3 mb-4">
                {{ $catatan ? $catatan->note : '' }}
            </div>

            <h5>Kepribadian</h5>
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kepribadian</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kepribadian as $kpr)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $kpr->list }}</td>
                            <td class="text-center">{{ $kpr->pivot->predicate }}</td>
                            <td class="text-center">{{ predicate($kpr->pivot->predicate) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/guardian/raport.js') }}"></script>
@endpush

@endsection