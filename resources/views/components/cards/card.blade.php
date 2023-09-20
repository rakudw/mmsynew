@props(['index' => false])

@php
    $class = ($index ?? false) ? 'card z-index-2 mb-3' : 'card mb-3';
@endphp

<div class="{{$class}}">
    {{ $slot }}
</div>
