<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kelas</th>
            <th>Pelajaran</th>
            <th>TM</th>
            <th>Jam&nbsp;ke</th>
            <th>Kompetensi</th>
            <th>Materi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($journals as $journal)
        <tr>
            <td>{{ $journal->date }}</td>
            <td>{{ $journal->subGrade->sub_grade }}</td>
            <td>{{ $journal->subject->subject }}</td>
            <td>{{ $journal->tm }}</td>
            <td>{{ $journal->jam_ke }}</td>
            <td>{{ $journal->competence->format_competence }}</td>
            <td>{{ $journal->matter }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
