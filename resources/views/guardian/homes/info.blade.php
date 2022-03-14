<div class="modal fade" id="info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoLabel">{{ $subject->subject }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            @foreach ($competences as $competence)
                            <th>{{ $competence->format_competence }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scores as $score)
                        <tr>
                            <td>{{ $score->nama }}</td>
                            @foreach ($competences as $competence)
                            @if($nilai = $score->{str_replace('.','_',$competence->format_competence)})
                            <td class="{{ homeColor($nilai, $competence->kkm) }}">{{ $nilai }}</td>
                            @else
                            <td>-</td>
                            @endif
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
