@props(['dynamic' =>false])

@php $class= ($dynamic ?? false) ? 'input-group input-group-dynamic' : 'input-group'; @endphp
<div class="{{$class}}">
    {{ $slot }}
</div>
