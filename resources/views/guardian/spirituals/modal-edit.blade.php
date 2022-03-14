@php
$check = explode(',', $spiritual->spirituals);
@endphp

<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/guardian/spirituals" method="post">
                @csrf @method('put')
                <input type="hidden" name="id" value="{{ $spiritual->id }}">
                <input type="hidden" name="student_version" value="{{ $spiritual->student_version_id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">{!! $spiritual->nama !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label fw-bold">Selalu dilakukan</label>
                        @foreach($lists as $list)
                        <div class="form-check">
                            <input class="form-check-input" name="spiritual[]" type="checkbox" id="{{ $list->id }}" value="{{ $list->id }}" {{ checked(in_array($list->id, $check)) }}>
                            <label class="form-check-label" for="{{ $list->id }}">
                                {{ $list->list }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold">Sudah dilakukan</label>
                        <select name="spiritual_id" class="form-select form-select-sm" id="sel" required>
                            <option hidden></option>
                            @foreach($lists as $list)
                            <option id="opt-{{ $list->id }}" value="{{ $list->id }}" {{ hidden(checked(in_array($list->id, $check))) }} {{ selected($spiritual->spiritual_id == $list->id) }}>{{ $list->list }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold">Predikat</label>
                        <select name="predicate" class="form-select form-select-sm">
                            @foreach(['A', 'B', 'C', 'D'] as $p)
                            <option value="{{ $p }}" {{ selected($spiritual->predicate == $p) }}>{{ $p }}</option>
                            @endforeach
                        </select>
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
