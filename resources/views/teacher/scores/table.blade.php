<div class="card-body">
    <div class="d-flex">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#info">
            <i data-feather="info"></i>
        </button>
        <div class="modal fade" id="info" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h5 class="modal-title text-white" id="infoLabel">Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-4">Pelajaran</div>
                            <div class="col-md-8"><strong>{{ $scores->subject->subject }}</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">Kelas</div>
                            <div class="col-md-8"><strong>{{ $scores->subGrade->sub_grade .' - '. $scores->subGrade->name }}</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">Kompetensi</div>
                            <div class="col-md-8"><strong>{{ $scores->competence->format_competence .' : '. $scores->competence->summary }}</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">KKM</div>
                            <div class="col-md-8"><strong>{{ $scores->competence->kkm }}</strong></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <form action="/teacher/scores/drop/{{ $name }}" method="post">
                            @csrf @method('delete')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus nilai ini?')"><i data-feather="x-circle" class="me-1"></i> Hapus Nilai</button>
                        </form>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown ms-2">
            <button class="btn btn-danger btn-sm dropdown-toggle me-1" type="button" id="delete-column" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hapus Kolom
            </button>
            <div class="dropdown-menu" aria-labelledby="delete-column" style="margin: 0px;">
                @foreach($fieldsScore as $column)
                <form action="/teacher/scores/remove" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="table" value="{{ $name }}">
                    <input type="hidden" name="column" value="{{ $column }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <button type="submit" class="dropdown-item" onclick="return confirm('Hapus kolom {{ Str::headline($column) }}')">{{ Str::headline($column) }}</button>
                </form>
                @endforeach
            </div>
        </div>

        <button type="button" class="btn btn-info btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#update-score">
            <i data-feather="edit"></i>
        </button>

        <div class="modal fade" id="update-score" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update-scoreLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="update-scoreLabel">Update nilai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/scores/edit" method="post" class="d-flex" id="score-edit">
                            @csrf
                            <input type="hidden" name="table" value="{{ $name }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <select name="column" class="form-select form-select-sm w-auto" id="column">
                                <optgroup label="SchoolWork">
                                    @foreach($scoreColumns->toArray() as $scoreColumn)
                                    <option value="{{ Str::snake($scoreColumn) }}">{{ $scoreColumn }}</option>
                                    @endforeach
                                </optgroup>
                                @if($type == 1)
                                <optgroup label="DailyTest">
                                    <option value="nilai">Nilai</option>
                                    <option value="r1">R1</option>
                                    <option value="r2">R2</option>
                                </optgroup>
                                @endif
                            </select>
                            <select name="index" class="form-select form-select-sm ms-2 w-auto" id="index">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <button type="submit" class="btn btn-info btn-sm ms-auto">Cari</button>
                        </form>
                    </div>
                    <form action="/teacher/scores" method="post">
                        @csrf @method('put')
                        <div class="table-responsive mt-2" id="table-edit">
                            {{-- Score by field --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit" disabled>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($check)
    <x-alert-form :action="'/teacher/scores/check/' . $name" message="Siswa perlu diperbaharui" :input="$check" name="student_id[]" />
    @endif
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-0">
        <thead class="text-center">
            <tr>
                <th>Nama</th>
                @foreach($fields as $field)
                <th>{{ Str::headline($field) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($students as $list)
            <tr class="text-center">
                <td class="text-start">{!! $list->nama !!}</td>
                @foreach($fields as $field)
                @if($field == 'keterangan')
                <td>{!! $list->status !!}</td>
                @else
                <td class="{{ scoreColor($field, $list->$field, $scores->competence->kkm) }}"><?= $list->$field ?></td>
                @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
