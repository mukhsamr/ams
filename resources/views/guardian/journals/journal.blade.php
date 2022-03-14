@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Jurnal</h3>
    <p class="text-subtitle text-muted">Jurnal harian guru kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>

<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-7 order-2 order-md-0">
            <form action="/guardian/journals" class="row g-1" id="search-journals">
                <div class="col-6 col-md-3">
                    <input type="date" name="start" class="form-control form-control-sm" value="{{ $start }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-6 col-md-3">
                    <input type="date" name="end" class="form-control form-control-sm" value="{{ $end }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-12 col-md-6">
                    <select name="subject" class="form-select form-select-sm" id="subject">
                        <option value="0" {{ selected($selected == 0) }}>Semua</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ selected($subject->id == $selected) }}>{{ $subject->subject }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-5 order-1 order-md-0 text-md-end">
            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#export">
                <i data-feather="download"></i>
            </button>
        </div>
        <div class="modal fade" id="export" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/guardian/journals/export" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportLabel">Export Jurnal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                    <label for="start">Mulai</label>
                                    <input type="date" name="start" class="form-control form-control-sm" required max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="end">Sampai</label>
                                    <input type="date" name="end" class="form-control form-control-sm" required max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12">
                                    <label for="subject">Pelajaran</label>
                                    <select name="subject" class="form-select form-select-sm">
                                        <option value="0">Semua</option>
                                        @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                        @endforeach
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
                        <th>Pelajaran</th>
                        <th>TM</th>
                        <th>Kompetensi</th>
                        <th>Materi</th>
                        <th>Guru</th>
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
                        <td>{{ $journal->subject }}</td>
                        <td>{{ $journal->tm }}</td>
                        <td>{{ competence($journal) }}</td>
                        <td><span class="short">{{ $journal->matter }}</span></td>
                        <td>{!! $journal->nama !!}</td>
                        <td class="text-center">{!! check_x($journal->is_swapped) !!}</td>
                        <td class="text-center">
                            <a href="/guardian/journals/edit/{{ $journal->id }}" class="btn btn-sm btn-info load-modal-journal" data-target="#edit"><i data-feather="edit"></i></a>
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
<script src="{{ asset('js/guardian/journals.js') }}"></script>
@endpush
