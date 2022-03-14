<table>
    <thead>
        <tr>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Kelas</th>
            <th colspan="2">Hadir</th>
            <th colspan="4">Tidak Hadir</th>
        </tr>
        <tr>
            <th>Tepat Waktu</th>
            <th>Terlambat</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Alpha</th>
            <th>Tanpa Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $nama => $status)
        <tr>
            <td>{{ $nama }}</td>
            <td>{{ $status['subGrade'] }}</td>
            @foreach(['Tepat Waktu', 'Terlambat', 'Sakit', 'Izin', 'Alpha', ''] as $key)
            <td>{{ $status[$key] ?? '-' }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
