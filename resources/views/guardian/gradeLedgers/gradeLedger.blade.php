@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Ledger Kelas</h3>
    <p class="text-subtitle text-muted">Ledger kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>

<section class="section">
    <div class="card mb-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 table-sm text-xs">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">Nama</th>
                        <th colspan="{{ count($subjects) }}" class="text-center">Nilai Pengetahuan</th>
                        <th class="text-center" rowspan="3">Rata-rata</th>
                        <th class="text-center" rowspan="3">Jumlah</th>
                        <th class="text-center" rowspan="3">Rangking</th>
                    </tr>
                    <tr>
                        @foreach ($subjects as $subject)
                        <th class="text-center">{{ $subject->subject }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>KKM</th>
                        @foreach ($subjects as $subject)
                        <th class="text-center">{{ $subject->kkm3 }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ledger3 as $l)
                    <tr>
                        <td>{{ $l->nama }}</td>
                        @foreach ($subjects as $subject)
                        <td class="text-center {{ ledgerColor($l->{$subject->id}, $subject->kkm3) }}">{{
                            $l->{$subject->id} }}</td>
                        @endforeach
                        <td class="text-center">{{ $l->avg }}</td>
                        <td class="text-center">{{ $l->sum }}</td>
                        <td class="text-center">{{ $l->rank }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 table-sm text-xs">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">Nama</th>
                        <th colspan="{{ count($subjects) }}" class="text-center">Nilai Keterampilan</th>
                        <th class="text-center" rowspan="3">Rata-rata</th>
                        <th class="text-center" rowspan="3">Jumlah</th>
                        <th class="text-center" rowspan="3">Rangking</th>
                    </tr>
                    <tr>
                        @foreach ($subjects as $subject)
                        <th class="text-center">{{ $subject->subject }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>KKM</th>
                        @foreach ($subjects as $subject)
                        <th class="text-center">{{ $subject->kkm4 }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ledger4 as $l)
                    <tr>
                        <td>{{ $l->nama }}</td>
                        @foreach ($subjects as $subject)
                        <td class="text-center {{ ledgerColor($l->{$subject->id}, $subject->kkm4) }}">{{
                            $l->{$subject->id} }}</td>
                        @endforeach
                        <td class="text-center">{{ $l->avg }}</td>
                        <td class="text-center">{{ $l->sum }}</td>
                        <td class="text-center">{{ $l->rank }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection