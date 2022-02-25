@php
$check_e = explode(',', $ekskul->ekskuls);
$pre_e = array_combine($check_e, explode(',', $ekskul->pre_e));

$check_p = explode(',', $ekskul->personalities);
$pre_p = array_combine($check_p, explode(',', $ekskul->pre_p));
@endphp

<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/guardian/ekskuls" method="post">
                @csrf @method('put')
                <input type="hidden" name="student_version" value="{{ $ekskul->student_version_id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">{!! $ekskul->nama !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="accordion accordion-flush" id="accordionParent">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-ekskul" aria-expanded="false" aria-controls="flush-ekskul">
                                    Ekskul
                                </button>
                            </h2>
                            <div id="flush-ekskul" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionParent">
                                <div class="accordion-body">
                                    @foreach($ekskuls as $list)
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" name="ekskul[]" type="checkbox" value="{{ $list->id }}" id="#e-{{ $list->id }}" {{ checked(in_array($list->id,$check_e)) }}>
                                            <label class="form-check-label" for="#e-{{ $list->id }}">
                                                {{ $list->list }}
                                            </label>
                                        </div>
                                        <select name="pre_e[]" class="form-select form-select-sm w-auto" id="e-{{ $list->id }}" {{ disabled(!in_array($list->id,$check_e)) }}>
                                            @foreach(['A', 'B', 'C', 'D'] as $p)
                                            <option value="{{ $p }}" {{ selected(($pre_e[$list->id] ?? null) == $p) }}>{{ $p }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-personality" aria-expanded="false" aria-controls="flush-personality">
                                    Kepribadian
                                </button>
                            </h2>
                            <div id="flush-personality" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionParent">
                                <div class="accordion-body">
                                    @foreach($personalities as $list)
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" name="personality[]" type="checkbox" value="{{ $list->id }}" id="#p-{{ $list->id }}" {{ checked(in_array($list->id,$check_p)) }}>
                                            <label class="form-check-label" for="#p-{{ $list->id }}">
                                                {{ $list->list }}
                                            </label>
                                        </div>
                                        <select name="pre_p[]" class="form-select form-select-sm w-auto" id="p-{{ $list->id }}" {{ disabled(!in_array($list->id,$check_p)) }}>
                                            @foreach(['A', 'B', 'C', 'D'] as $p)
                                            <option value="{{ $p }}" {{ selected(($pre_p[$list->id] ?? null) == $p) }}>{{ $p }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
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
