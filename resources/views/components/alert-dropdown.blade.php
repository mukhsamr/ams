<div class="accordion mb-2">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#list" aria-expanded="true" aria-controls="list">
                {!! $message() !!}
            </button>
        </h2>
        <div id="list" class="accordion-collapse collapse">
            <div class="accordion-body">
                <ul>
                    @foreach($failures as $failure)
                    <li>Baris {{ $failure->row().', '. implode(', ',$failure->errors()) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
