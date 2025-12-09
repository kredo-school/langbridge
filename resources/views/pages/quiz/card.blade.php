@foreach($questions as $question)
    <p>front:{{ $question->front }}</p>
    <p>back:{{ $question->back }}</p>
@endforeach