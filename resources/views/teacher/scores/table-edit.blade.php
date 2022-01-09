<input type="hidden" name="table" value="{{ $table }}">
<input type="hidden" name="field" value="{{ $field }}">
<input type="hidden" name="type" value="{{ $type }}">
<table class="table table-bordered mb-0">
    <thead class="text-center">
        <tr>
            <th>Nama</th>
            <th>{{ Str::headline($field) }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($scores as $score)
        <tr>
            <td>{!! $score->studentVersion->student->nama !!}</td>
            <td class="text-center w-25">
                <input type="number" name="{{ $field }}[{{ $score->studentVersion->id }}]" step="0.1" min="0" max="100" class="form-control" value="{{ $score->$field }}">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
