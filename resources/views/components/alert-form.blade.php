<div class="alert alert-info mb-0 mt-3" role="alert">
    <form action="{{ $action }}" method="post" class="d-flex justify-content-between">
        @csrf
        <span class="my-auto">{{ $message }}</span>
        @foreach($input as $id)
        <input type="hidden" name="{{ $name }}" value="{{ $id }}">
        @endforeach
        <button type="submit" class="btn p-1 text-white"><i data-feather="rotate-ccw"></i></button>
    </form>
</div>
