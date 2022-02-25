<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jam&nbsp;ke</th>
            <th>Kelas</th>
            <th>Pelajaran</th>
            <th>TM</th>
            <th>Kompetensi</th>
            <th>Materi</th>
            <th>Pengganti</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($journals as $journal)
        <tr>
            <td>{{ $journal->format_date }}</td>
            <td>{{ $journal->jam_ke }}</td>
            <td>{{ $journal->sub_grade }}</td>
            <td>{{ $journal->subject }}</td>
            <td>{{ $journal->tm }}</td>
            <td>{{ competence($journal) }}</td>
            <td>{{ $journal->matter }}</td>
            <td>{{ $journal->is_swapped ? 'YA' : 'TIDAK' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
