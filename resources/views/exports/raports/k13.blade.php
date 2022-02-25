<div class="center" style="font-size: 14px"><strong>LAPORAN HASIL BELAJAR SISWA</strong></div>
<div class="flex margin">
    <div class="item" style="width: 55%;">
        <div class="flex">
            <div class="item" style="width: 40%;">
                <div>Nama Sekolah</div>
                <div>Nama Peserta Didik</div>
                <div>No. Induk Siswa/NISN</div>
            </div>
            <div class="item" style="width: 60%;">
                <div>: {{ $school->name }}</div>
                <div>: {!! $student->nama !!}</div>
                <div>: {{ $student->nipd . ' - ' . $student->nisn }}</div>
            </div>
        </div>
    </div>
    <div class="item" style="width: 45%;">
        <div class="flex">
            <div class="item" style="width: 40%;">
                <div>Kelas</div>
                <div>Semester</div>
                <div>Academic Year</div>
            </div>
            <div class="item" style="width: 60%;">
                <div>: {{ toRoman($subGrade->grade->grade) . ' ' . $subGrade->name }}</div>
                <div>: {{ toRoman($version->semester) . ' ' . ($version->semester == 1 ? '(Satu)' : '(Dua)') }}</div>
                <div>: {{ $version->school_year }}</div>
            </div>
        </div>
    </div>
</div>

<h5>A. SIKAP</h5>
<table>
    <thead>
        <tr>
            <th id="no">No</th>
            <th class="column2-5">Nilai</th>
            <th class="column2">Predikat</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sikap as $type => $skp)
        <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $type }}</td>
            <td class="center">{{ $skp->predicate ?? '-' }}</td>
            <td>{{ $skp ? "Ananda $skp->called $skp->comment" : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h5>B. PENGETAHUAN</h5>
<table>
    <thead>
        <tr>
            <th id="no">No</th>
            <th class="column2-5">Mata Pelajaran</th>
            <th class="column">KKM</th>
            <th class="column">Nilai</th>
            <th class="column">Predikat</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengetahuan as $local)
        @foreach($local as $subject => $png)
        <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $subject }}</td>
            <td class="center">{{ $png->kkm ?? $png['kkm'] ?? '-' }}</td>
            <td class="center">{{ $png->hpa ?? $png['hpa'] ?? '-' }}</td>
            <td class="center">{{ $png->pre ?? '-' }}</td>
            <td>{{ $png ? "Ananda $png->called $png->deskripsi" : '-' }}</td>
        </tr>
        @endforeach
        @if ($loop->first)
        <tr>
            <th colspan="6" class="left">Muatan Lokal</th>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

<pagebreak>
    <h5>C. KETERAMPILAN</h5>
    <table>
        <thead>
            <tr>
                <th id="no">No</th>
                <th class="column2-5">Mata Pelajaran</th>
                <th class="column">KKM</th>
                <th class="column">Nilai</th>
                <th class="column">Predikat</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keterampilan as $local)
            @foreach($local as $subject => $ktr)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $subject }}</td>
                <td class="center">{{ $ktr->kkm }}</td>
                <td class="center">{{ $ktr->rph }}</td>
                <td class="center">{{ $ktr->pre ?? '-' }}</td>
                <td>{{ $ktr ? "Ananda $ktr->called $ktr->deskripsi" : '-' }}</td>
            </tr>
            @endforeach
            @if ($loop->first)
            <tr>
                <th colspan="6" class="left">Muatan Lokal</th>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <div class="item" style="width:45%;">
        <h5>Kegiatan Pengembangan Diri</h5>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 8.625%">No</th>
                    <th>Kegiatan</th>
                    <th style="width: 17.25%">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ekskul as $eks)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $eks->list }}</td>
                    <td class="center">{{ $eks->pivot->predicate }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="item" style="width:50%; margin-left: 5%;">
        <h5>Catatan Kehadiran</h5>
        <table style="width: 100%">
            <thead class="text-center">
                <tr>
                    <th>Alasan</th>
                    <th style="width: 15%">Hari</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absen as $status => $abs)
                <tr>
                    <td>{{ $status }}</td>
                    <td class="center">{{ $abs ? $abs->count : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h5>Catatan Guru Wali Kelas</h5>
    <div id="notes">
        {{ $catatan ? $catatan->note : '' }}
    </div>
</pagebreak>




<pagebreak>
    <h5>Kepribadian</h5>
    <table>
        <thead>
            <tr>
                <th id="no">No</th>
                <th>Kepribadian</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kepribadian as $kpr)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $kpr->list }}</td>
                <td class="center">{{ $kpr->pivot->predicate }}</td>
                <td class="center">{{ predicate($kpr->pivot->predicate) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="margin2 right">{{ $setting->place }}</div>
    <div class="margin">Acknowledged by</div>
    <div class="margin flex">
        <div class="item" style="width: 33.3%">Headmistress</div>
        <div class="item center" style="width: 33.3%">Parents / Guardians Parents</div>
        <div class="item right" style="width: 33.3%">Homebase Teacher</div>
    </div>
    <div class="margin flex">
        <div class="item img">
            @if ($setting->background)
            <img src="{{ $school->signature }}" alt="signature" style="width: auto; height: 90px;">
            @endif
        </div>
        <div class="item img center">
            @if ($setting->background)
            <img style="width: auto; height: 90px;">
            @endif
        </div>
        <div class="item right img">
            @if ($setting->background)
            <img src="{{ asset('storage/img/guardians/' . $guardian->signature) }}" alt="signature"
                style="width: auto; height: 90px;">
            @endif
        </div>
    </div>
    <div class="margin flex">
        <div class="item" style="width: 33.3%"><strong>{!! $school->teacher->nama !!}</strong></div>
        <div class="item center" style="width: 33.3%">..........................................</div>
        <div class="item right" style="width: 33.3%"><strong>{!! $guardian->nama !!}</strong></div>
    </div>
</pagebreak>

@if ($setting->background)
<style>
    @page {
        background-image: url('{{ $school->logo }}');
        background-image-resize: 4;
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center;
        background-image-opacity: 0.15;
    }
</style>
@endif
<style>
    body,
    html {
        font-size: 12px;
    }

    h5 {
        font-size: 14px;
        margin: 12px 0 6px 0;
    }

    table,
    th,
    td {
        font-size: 11px;
        padding: 4px;
        border: 1px solid black;
        border-collapse: collapse;
    }

    #no {
        width: 3.75%;
        text-align: center
    }

    .center {
        text-align: center;
    }

    .flex {
        display: flex;
    }

    .item {
        float: left;
    }

    .margin {
        margin-top: 12px;
    }

    .margin2 {
        margin-top: 24px;
    }

    .right {
        text-align: right;
    }

    .left {
        text-align: left;
    }

    .column {
        width: 7.5%;
    }

    .column2 {
        width: 15%;
    }

    .column2-5 {
        width: 18.75%;
    }

    .img {
        width: 33%;
        height: 90px;
    }

    #notes {
        border: 1px solid black;
        padding: 6px;
    }
</style>