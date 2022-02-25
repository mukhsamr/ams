@foreach($object as $option)
<option value="{{ $option->$value }}">{{ $option->$text }}</option>
@endforeach
