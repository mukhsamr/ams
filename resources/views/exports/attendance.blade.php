<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Datang</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $attendance)
        <tr>
            <td>{{ $attendance->format_date }}</td>
            <td>{!! $attendance->user->userable->nama !!}</td>
            <td>{{ $attendance->hours }}</td>
            <td>{!! $attendance->format_status !!}</td>
            <td>{{ $attendance->etc }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
