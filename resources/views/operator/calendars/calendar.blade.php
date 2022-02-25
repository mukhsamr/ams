@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Kalender</h3>
    <p class="text-subtitle text-muted">Kalender hari libur dan event</p>
</div>
<hr>
<section class="section">
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-6 order-2 order-md-0">
            <form action="/calendar" method="get">
                <input type="month" class="form-control form-control-sm w-auto" name="month" id="search" onchange="this.form.submit()" value="{{ $month }}">
            </form>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-0 d-flex justify-content-md-end">
            <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#add">
                <i data-feather="plus"></i>
            </button>

            <form action="/calendar/api" method="post">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Import google kalender')"><i data-feather="globe"></i></button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/calendar" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLabel">Tambah event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start">Tanggal</label>
                            <input type="date" name="start" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="end">Event</label>
                            <textarea name="summary" class="form-control form-control-sm" required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input name="is_holiday" class="form-check-input" type="checkbox" role="switch" id="holiday" value="1">
                                <label class="form-check-label" for="holiday">Libur</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($errors->any())
    <x-alert type="warning" :warning="implode(', ', $errors->all())" />
    @endif

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Event</th>
                        <th>Libur</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calendars as $calendar)
                    <tr>
                        <td>{{ $calendar->format_start }}</td>
                        <td>{{ $calendar->summary }}</td>
                        <td class="text-center">{!! $calendar->format_is_holiday !!}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $calendar->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $calendar->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $calendar->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/calendar" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $calendar->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $calendar->id }}Label">{{ $calendar->format_start }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="start">Tanggal</label>
                                                <input type="date" name="start" class="form-control form-control-sm" value="{{ $calendar->start }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="end">Event</label>
                                                <textarea name="summary" class="form-control form-control-sm" required>{{ $calendar->summary }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check form-switch">
                                                    <input name="is_holiday" class="form-check-input" type="checkbox" role="switch" id="holiday" value="1" {{ $calendar->is_holiday ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="holiday">Libur</label>
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
                        <td class="text-center">
                            <form action="/calendar/{{ $calendar->id }}" method="post">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus event {{ $calendar->format_start }}')"><i data-feather="trash"></i></button>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $calendars->links() }}
</section>

@push('scripts')
<script src="{{ asset('js/admin/calendar.js') }}"></script>
@endpush

@endsection
