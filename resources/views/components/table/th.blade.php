@props(['center'])
@php
    $classes = ($center ?? false)
                ? 'align-middle text-center text-sm'
                : 'text-left text-sm';
@endphp
<th {{ $attributes->merge(['rowspan' => '', 'colspan' => '', 'class'=>$classes]) }}>{{ $slot }}</th>
