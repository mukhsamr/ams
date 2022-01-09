@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Jurnal</h3>
    <p class="text-subtitle text-muted">Jurnal harian guru kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>

<hr>

<section class="section">
    <div class="d-flex justify-content-between mb-3">
        <form action="/guardian/journals" id="search-journals">
            <select name="subject" class="form-select form-select-sm w-auto">
                <option value="0" {{ $selected == '0' ? 'selected' : '' }}>Semua</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $subject->id == $selected ? 'selected' : '' }}>{{ $subject->subject }}</option>
                @endforeach
            </select>
        </form>

        <div class="d-flex">
            <form action="/guardian/journals/export/{{ $subGrade->id }}/{{ $selected ?? 0 }}" method="post">
                @csrf
                <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('Download jurnal?')">
                    <i data-feather="download"></i>
                </button>
            </form>
        </div>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($import = session('import'))
    <x-alert-dropdown :total="$import->getRowCount('total')" :success="$import->getRowCount('success')" :failures="$import->failures()" />
    @endif


    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Pelajaran</th>
                        <th>TM</th>
                        <th>Jam&nbsp;ke</th>
                        <th>Kompetensi</th>
                        <th>Materi</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($journals as $journal)
                    <tr>
                        <td>{{ $journal->format_date }}</td>
                        <td class="text-center">{{ $journal->subGrade->sub_grade }}</td>
                        <td class="text-center">{{ $journal->subject->subject }}</td>
                        <td class="text-center">{{ $journal->tm }}</td>
                        <td class="text-center">{{ $journal->jam_ke }}</td>
                        <td class="text-center">{{ $journal->competence->format_competence }}</td>
                        <td>{{ $journal->matter }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#update-journal-{{ $journal->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="update-journal-{{ $journal->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update-journalLabel-{{ $journal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/teacher/journals/update/{{ $journal->id }}" method="post">
                                        @csrf @method('put')
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title text-white" id="update-journalLabel-{{ $journal->id }}">Edit Jurnal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="date">Tanggal</label>
                                                        <input type="date" id="date" class="form-control form-control-sm" name="date" max="{{ date('Y-m-d') }}" value="{{ $journal->date }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="subject">Pelajaran</label>
                                                        <select name="subject_id" id="subject-{{ $journal->id }}" data-id="{{ $journal->id }}" class="form-select form-select-sm" required>
                                                            <option hidden></option>
                                                            @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}" {{ $journal->subject->id == $subject->id ? 'selected' : '' }}>{{ $subject->subject }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="tm">TM</label>
                                                        <input type="number" name="tm" class="form-control form-control-sm" id="tm" value="{{ $journal->tm }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="jam_ke">Jam ke</label>
                                                        <select name="jam_ke" id="jam_ke" class="form-select form-control-sm" required>
                                                            <option hidden></option>
                                                            @for($i = 1; $i < 5; $i++) <option value="{{ $i }}" {{ $journal->jam_ke == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="sub_grade">Kelas</label>
                                                        <select name="sub_grade_id" id="sub_grade-{{ $journal->id }}" class="form-select form-select-sm">
                                                            <option value="{{ $subGrade->id }}">{{ $subGrade->sub_grade }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="competence">Kompetensi</label>
                                                        <select name="competence_id" id="competence-{{ $journal->id }}" data-id="{{ $journal->id }}" class="form-select form-select-sm" required>
                                                            <option hidden></option>
                                                            @foreach($competences as $competence)
                                                            <option {{ ($competence->subject_id == $journal->competence->subject_id) && ($competence->grade->id == $journal->competence->grade->id) ? '' : 'hidden' }} value="{{ $competence->id }}" subject="{{ $competence->subject_id }}" grade="{{ $competence->grade }}" data-summary="{{ $competence->summary }}" {{ $journal->competence->id == $competence->id ? 'selected' : '' }}>
                                                                {{ $competence->format_competence }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <textarea class="form-control form-control-sm mt-2" id="summary-{{ $journal->id }}" disabled>{{ $journal->competence->summary }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="matter">Materi / Metode</label>
                                                        <textarea name="matter" id="matter" class="form-control form-control-sm" required>{{ $journal->matter }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <td class="text-center">
                            <form action="/teacher/journals/{{ $journal->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jurnal {{ $journal->date }}')">
                                    <i data-feather="trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $journals->links() }}
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/guardian/journals.js') }}"></script>
@endpush
