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
                            <div class="col-md-8"><strong>{{ $ledger->subject->subject }}</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">Kelas</div>
                            <div class="col-md-8"><strong>{{ $ledger->subGrade->sub_grade }}</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">Aspek</div>
                            <div class="col-md-8"><strong>{{ $type == '1' ? 'Pengetahuan' : 'Keterampilan' }}</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">KKM</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12">
                                        <strong>{{ $kkm }}</strong>
                                    </div>
                                    <div class="col-12">
                                        <ul class="ps-3 m-0">
                                            @foreach($competences as $competence)
                                            <li>{{ $competence->format_competence .' | '. $competence->kkm}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">Predikat</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="ps-3 m-0">
                                            <li><strong class="text-primary">A</strong> = {{ $A = ceil(100 - $interval) }} - 100</li>
                                            <li><strong class="text-success">B</strong> = {{ $B = ceil(100 - $interval * 2) .' - '. (floatval($A) - 1) }}</li>
                                            <li><strong class="text-warning">C</strong> = {{ $C = ceil(100 - $interval * 3) .' - '. (floatval($B) - 1) }}</li>
                                            <li><strong class="text-danger">D</strong> = {{ '0 - '. (floatval($C) - 1) }}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <form action="/teacher/ledgers/load" method="post">
            @csrf
            <input type="hidden" name="name" value="{{ session(request()->path())->name }}">
            <input type="hidden" name="subject" value="{{ session(request()->path())->subject_id }}">
            <input type="hidden" name="sub_grade" value="{{ session(request()->path())->sub_grade_id }}">
            <input type="hidden" name="type" value="{{ session(request()->path())->type }}">
            <button type="submit" class="btn btn-warning btn-sm ms-2">
                <i data-feather="refresh-cw"></i>
            </button>
        </form>

        @if($type == 1)
        <button type="button" class="btn btn-info btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#update-ledger">
            <i data-feather="edit"></i>
        </button>
        <div class="modal fade" id="update-ledger" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update-ledgerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/teacher/ledgers" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update-ledgerLabel">Nilai PAS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @csrf @method('put')
                        <div class="table-responsive mt-2" id="table-edit">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th class="text-center">PAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" name="name" value="{{ session(request()->path())->name }}">
                                    @foreach($lists as $list)
                                    <tr class="text-center">
                                        <td class="text-start">{!! $list->studentVersion->student->nama !!}</td>
                                        <td class="text-center w-25">
                                            <input type="number" name="pas[{{ $list->studentVersion->student->id }}]" class="form-control form-control-sm" step="0.1" min="0" max="100" value="{{ $list->pas }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm me-auto" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-0">
        <thead class="text-center">
            <tr>
                <th>Nama</th>
                @foreach($fields as $field)
                <th>{{ $field == 'deskripsi' ? 'Deskripsi' : strtoupper(str_replace('_','.',$field)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $list)
            <tr class="text-center">
                <td class="text-start">{!! $list->studentVersion->student->nama !!}</td>
                @foreach($fields as $field)
                @if($field == 'deskripsi')
                <td class="text-start"><span class="short" data-short="30">{{ $list->$field }}</span></td>
                @else
                <td class="{{ ledgerColor($list->$field, $kkm) }}">{!! $list->$field !!}</td>
                @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
