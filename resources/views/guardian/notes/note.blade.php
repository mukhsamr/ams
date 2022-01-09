@extends('layout.template')

@section('content')

<div class="page-title">
    <h3>Catatan</h3>
    <p class="text-subtitle text-muted">Isian catatan siswa kelas <strong>{{ $subGrade->sub_grade }}</strong></p>
</div>
<hr>
<section class="section">

    @if($alert = session('alert'))
    <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif

    @if($check)
    <x-alert-form action="/guardian/notes" message="Siswa perlu diperbaharui" :input="$check" name="student_version_id[]" />
    @endif

    <div class="card mt-2">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Panggilan</th>
                        <th>Catatan</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alpha</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td>{!! $note->studentVersion->student->nama !!}</td>
                        <td>{{ $note->called }}</td>
                        <td><span class="short">{{ $note->note }}</span></td>
                        <td class="text-center">{{ $note->sakit }}</td>
                        <td class="text-center">{{ $note->izin }}</td>
                        <td class="text-center">{{ $note->alpha }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $note->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="edit-{{ $note->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-{{ $note->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/guardian/notes" method="post">
                                        @csrf @method('put')
                                        <input type="hidden" name="id" value="{{ $note->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-{{ $note->id }}Label">{!! $note->studentVersion->student->nama !!}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" name="nama" class="form-control form-control-sm" value="{!! $note->studentVersion->student->nama !!}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="panggilan">Panggilan</label>
                                                <input type="text" name="called" class="form-control form-control-sm" value="{{ $note->called }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="note">Catatan</label>
                                                <textarea name="note" class="form-control form-control-sm">{{ $note->note }}</textarea>
                                            </div>
                                            <div class="row g-2">
                                                <div class="form-group col-4">
                                                    <label for="sakit">Sakit</label>
                                                    <input type="number" name="sakit" class="form-control form-control-sm" value="{{ $note->sakit }}" min="0">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="izin">Izin</label>
                                                    <input type="number" name="izin" class="form-control form-control-sm" value="{{ $note->izin }}" min="0">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="alpha">Alpha</label>
                                                    <input type="number" name="alpha" class="form-control form-control-sm" value="{{ $note->alpha }}" min="0">
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
