<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/teacher/competences" method="post">
                @csrf @method('put')
                <input type="hidden" name="id" value="{{ $competence->id }}">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="editLabel">Update Kompetensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="subject">Pelajaran</label>
                                <select name="subject_id" class="form-select form-select-sm" required {{ disabled($competence->used) }}>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ selected($competence->subject_id == $subject->id) }}>{{ $subject->subject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="grade">Kelas</label>
                                <select name="grade_id" class="form-select form-select-sm" required {{ disabled($competence->used) }}>
                                    <option value="{{ $grade->id }}" {{ selected($competence->grade_id == $grade->id) }}>{{ $grade->grade }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="competence">Kode</label>
                                <div class="input-group">
                                    <select name="type" class="form-select form-select-sm" id="type" required>
                                        <option value="1" {{ selected($competence->type == '1') }}>3.</option>
                                        <option value="2" {{ selected($competence->type == '2') }}>4.</option>
                                    </select>
                                    <input type="number" step="1" name="competence" class="form-control form-control-sm" value="{{ $competence->competence }}" style="width:50%">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kkm">KKM</label>
                                <input type="number" name="kkm" class="form-control form-control-sm" step="0.1" min="0" max="100" value="{{ $competence->kkm }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="value">Kompetensi</label>
                                <textarea name="value" class="form-control form-control-sm" required>{{ $competence->value }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="summary">Deskripsi <strong>(75 Karakter)</strong></label>
                                <textarea name="summary" class="form-control form-control-sm" maxlength="75" required>{{ $competence->summary }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
