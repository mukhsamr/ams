<table>
    <thead>
        <tr>
            <th rowspan="2">Nama</th>
            <th colspan="2">Hadir</th>
            <th colspan="3">Tidak Hadir</th>
        </tr>
        <tr>
            <th>Tepat Waktu</th>
            <th>Terlambat</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Tanpa Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $nama => $status)
        <tr>
            <td>{{ $nama }}</td>
            @foreach(['Tepat Waktu', 'Terlambat', 'Sakit', 'Izin', ''] as $key)
            <td>{{ $status[$key] ?? '-' }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
