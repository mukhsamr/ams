<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/teacher/journals" method="post">
                @csrf @method('put')
                <input type="hidden" name="id" value="{{ $journal->id }}">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="editLabel">Edit Jurnal</h5>
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
                                <select name="subject_id" id="subject" class="form-select form-select-sm" required>
                                    <option hidden></option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ selected($journal->subject_id == $subject->id) }}>{{ $subject->subject }}</option>
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
                                <select name="jam_ke" id="jam_ke" class="form-select form-select-sm" required>
                                    <option hidden></option>
                                    @for($i = 1; $i < 5; $i++) <option value="{{ $i }}" {{ selected($journal->jam_ke == $i) }}>{{ $i }}</option> @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="sub_grade">Kelas</label>
                                <select name="sub_grade_id" id="sub_grade" class="form-select form-select-sm" required>
                                    <option hidden></option>
                                    @foreach($subGrades as $subGrade)
                                    <option value="{{ $subGrade->id }}" data-grade="{{ $subGrade->grade_id }}" {{ selected($journal->sub_grade_id == $subGrade->id) }}>{{ $subGrade->sub_grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="competence">Kompetensi</label>
                                <select name="competence_id" id="competence" class="form-select form-select-sm" required>
                                    <option hidden></option>
                                    @foreach($competences as $competence)
                                    <option {{ hidden(!(($competence->subject_id == $journal->subject_id) && ($competence->grade_id == $journal->grade_id))) }} value="{{ $competence->id }}" subject="{{ $competence->subject_id }}" grade="{{ $competence->grade_id }}" data-summary="{{ $competence->summary }}" {{ selected($journal->competence_id == $competence->id) }}>
                                        {{ $competence->format_competence }}
                                    </option>
                                    @endforeach
                                </select>
                                <textarea class="form-control form-control-sm mt-2" id="summary" disabled>{{ $journal->summary }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="matter">Materi / Metode</label>
                                <textarea name="matter" id="matter" class="form-control form-control-sm" required>{{ $journal->matter }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="is_swapped" value="1" type="checkbox" role="switch" id="swap" {{ checked($journal->is_swapped) }}>
                                <label class="form-check-label" for="swap">Guru Pengganti</label>
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
