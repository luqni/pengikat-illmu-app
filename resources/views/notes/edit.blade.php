@php
    $action = route('notes.update', $note);
    $method = 'PUT';
    // $note sudah tersedia dari controller
@endphp

@include('notes.form')
