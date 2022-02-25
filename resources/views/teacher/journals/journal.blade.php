@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Jurnal</h3>
    <p class="text-subtitle text-muted">Jurnal harian guru</p>
</div>

<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/teacher/journals" class="row g-1">
                <div class="col-9">
                    <select name="subject" class="form-select form-select-sm" id="subject-search">
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ selected($subject->id == $selected['subject']) }}>{{ $subject->subject }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="subGrade" class="form-select form-select-sm" id="subGrade-search">
                        @foreach($subGrades as $subGrade)
                        <option value="{{ $subGrade->id }}" {{ selected($subGrade->id == $selected['subGrade']) }}>{{ $subGrade->sub_grade }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-0 d-flex justify-content-md-end">
            <a href="/teacher/journals/create" class="btn btn-sm btn-success load-modal-journal me-1" data-target="#create"><i data-feather="plus"></i></a>

            <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#upload-journal">
                <i data-feather="upload"></i>
            </button>
            <div class="modal fade" id="upload-journal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-journalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/teacher/journals/import" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white" id="add-journalLabel">Upload Jurnal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="grade" class="form-label">Kelas</label>
                                            <select name="sub_grade" class="form-select">
                                                @foreach($subGrades as $subGrade)
                                                <option value="{{ $subGrade->id }}">{{ $subGrade->sub_grade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="subject" class="form-label">Pelajaran</label>
                                            <select name="subject" class="form-select">
                                                @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="import" class="form-label">Pilih File</label>
                                            <input class="form-control" name="import" type="file">
                                            <small class="text-muted fw-bold"><em id="size"></em></small>
                                        </div>
                                        <a href="{{ asset('template/Template Jurnal.xlsx') }}"><small>Download Tempate</small></a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#export">
                <i data-feather="download"></i>
            </button>

            <div class="modal fade" id="export" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/teacher/journals/export" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exportLabel">Export Jurnal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <label for="start">Dari</label>
                                        <input type="date" name="start" class="form-control form-control-sm" required max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="end">Sampai</label>
                                        <input type="date" name="end" class="form-control form-control-sm" required max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="subject">Pelajaran</label>
                                        <select name="subject" class="form-select form-select-sm" required>
                                            @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                            @endforeach
                                            <option value="0">Semua</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="sub_grade">Kelas</label>
                                        <select name="sub_grade" class="form-select form-select-sm" required>
                                            @foreach($subGrades as $subGrade)
                                            <option value="{{ $subGrade->id }}">{{ $subGrade->sub_grade }}</option>
                                            @endforeach
                                            <option value="0">Semua</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-dark">Download</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam&nbsp;ke</th>
                        <th>Kelas</th>
                        <th>Pelajaran</th>
                        <th>TM</th>
                        <th>Kompetensi</th>
                        <th>Materi</th>
                        <th>Pengganti</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($journals as $journal)
                    <tr>
                        <td>{{ $journal->format_date }}</td>
                        <td>{{ $journal->jam_ke }}</td>
                        <td>{{ $journal->sub_grade }}</td>
                        <td>{{ $journal->subject }}</td>
                        <td>{{ $journal->tm }}</td>
                        <td>{{ competence($journal) }}</td>
                        <td><span class="short">{{ $journal->matter }}</span></td>
                        <td class="text-center">{!! check_x($journal->is_swapped) !!}</td>
                        <td class="text-center">
                            <a href="/teacher/journals/edit/{{ $journal->id }}" class="btn btn-sm btn-info load-modal-journal" data-target="#edit"><i data-feather="edit"></i></a>
                        </td>
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

    <div id="modal"></div>
    {{ $journals->links() }}
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/teacher/journals.js') }}"></script>
@endpush
