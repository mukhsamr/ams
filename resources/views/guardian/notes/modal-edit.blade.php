<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/guardian/notes" method="post">
                @csrf @method('put')
                <input type="hidden" name="id" value="{{ $note->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">{!! $note->nama !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control form-control-sm" value="{!! $note->nama !!}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="panggilan">Panggilan</label>
                        <input type="text" name="called" class="form-control form-control-sm" value="{{ $note->called }}">
                    </div>
                    <div class="form-group">
                        <label for="note">Catatan</label>
                        <textarea name="note" class="form-control form-control-sm">{{ $note->note }}</textarea>
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
