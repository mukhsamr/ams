<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/teacher/scores" method="post">
                @csrf
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="createLabel">Tambah nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="subject">Pelajaran</label>
                                <select name="subject" class="form-select form-select-sm" id="add-subject" required>
                                    @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" data-subject="{{ $subject->id }}">{{ $subject->subject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="sub_grade">Kelas</label>
                                <select name="sub_grade" class="form-select form-select-sm" id="add-subGrade" required>
                                    <option hidden></option>
                                    @foreach ($subGrades as $subGrade)
                                    <option value="{{ $subGrade->id }}" data-grade="{{ $subGrade->grade_id }}">{{ $subGrade->sub_grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="competence">Kompetensi</label>
                                <select name="competence" class="form-select form-select-sm" id="add-competence" required>
                                    <option hidden></option>
                                    @foreach ($competences as $com)
                                    <option hidden value="{{ $com->id }}" subject="{{ $com->subject_id }}" grade="{{ $com->grade_id }}" data-summary="{{ $com->summary }}">{{ $com->format_competence }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="summary">Ringkasan</label>
                                <textarea class="form-control" id="summary" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
