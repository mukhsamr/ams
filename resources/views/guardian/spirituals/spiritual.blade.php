@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Spiritual</h3>
    <p class="text-subtitle text-muted">Isian spiritual siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($check)
    <x-alert-form action="/guardian/spirituals" message="Siswa perlu diperbaharui" :input="$check" name="student_version_id[]" />
    @endif

    <div class="card mt-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Sikap selalu dilakukan</th>
                        <th>Sikap sudah menunjukan</th>
                        <th>Komentar</th>
                        <th>Predikat</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spirituals as $spiritual)
                    <tr>
                        <td>{!! $spiritual->studentVersion->student->nama !!}</td>
                        <td>
                            <ul>
                                @foreach($checked = $spiritual->studentVersion->spiritual->pluck('list', 'id') as $list)
                                <li>{{ $list }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $spiritual->spiritual->list ?? '' }}</td>
                        <td><span class="short">{{ $spiritual->comment }}</span></td>
                        <td class="text-center">{{ $spiritual->predicate }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $spiritual->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $spiritual->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $spiritual->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/guardian/spirituals" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $spiritual->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $spiritual->id }}Label">{!! $spiritual->studentVersion->student->nama !!}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Selalu dilakukan</label>
                                                @foreach($lists as $list)
                                                <div class="form-check">
                                                    <input class="form-check-input" name="spiritual[]" type="checkbox" data-id="{{ $spiritual->id }}" value="{{ $list->id }}" id="list-{{ $list->id . '-' . $spiritual->id }}" {{ $checked->has($list->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="list-{{ $list->id . '-' . $spiritual->id }}">
                                                        {{ $list->list }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Sudah dilakukan</label>
                                                <select name="spiritual_id" class="form-select form-select-sm" id="sel-{{ $spiritual->id }}" required>
                                                    <option hidden></option>
                                                    @foreach($lists as $list)
                                                    <option id="opt-list-{{ $list->id . '-' . $spiritual->id }}" value="{{ $list->id }}" {{ $checked->has($list->id) ? 'hidden' : '' }} {{ $spiritual->spiritual_id == $list->id ? 'selected' : '' }}>{{ $list->list }}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Predikat</label>
                                                <select name="predicate" class="form-select form-select-sm">
                                                    @foreach(['A', 'B', 'C', 'D'] as $p)
                                                    <option value="{{ $p }}" {{ $spiritual->predicate == $p ? 'selected' : '' }}>{{ $p }}</option>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/guardian/spiritual.js') }}"></script>
@endpush
