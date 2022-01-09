@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Versi</h3>
    <p class="text-subtitle text-muted">Versi tahun ajaran dan semester</p>
</div>
<hr>
<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Dipilih</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($versions as $version)
                    <tr class="text-center">
                        <td>{{ $version->school_year }}</td>
                        <td>{{ $version->semester }}</td>
                        <td>
                            <form action="/versions" method="post">
                                @csrf @method('put')
                                <input type="hidden" name="id" value="{{ $version->id }}">
                                <button type="submit" class="btn btn-sm {{ $version->is_used ? 'btn-success disabled' : 'btn-secondary' }}">{{ $version->is_used ? 'Dipilih' : 'Pilih' }}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/admin/version.js') }}"></script>
@endpush

@endsection
