@props(['editor' => false, 'id'])

<textarea {{ $editor ? 'editor' : '' }} {!! $attributes->merge(['class' => 'form-control', 'id'=> $id]) !!}></textarea>
