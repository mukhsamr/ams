@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Kalender</h3>
    <p class="text-subtitle text-muted">Kalender hari libur dan event</p>
</div>
<hr>
<section class="section">

    <form action="/teacher/calendars" method="get" class="mb-2">
        <input type="month" class="form-control form-control-sm w-auto" name="month" id="search" onchange="this.form.submit()" value="{{ $month }}">
    </form>

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Event</th>
                        <th>Libur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calendars as $calendar)
                    <tr>
                        <td>{{ $calendar->format_start }}</td>
                        <td>{{ $calendar->summary }}</td>
                        <td class="text-center">{!! $calendar->format_is_holiday !!}</td>
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
