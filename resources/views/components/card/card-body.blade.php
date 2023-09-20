@props(['isTab' => false, 'id'=> ''])
@php
    $isTab = ($isTab ?? false) ? 'tab-content' : 'p-lg-4 p-md-3';
@endphp
<div {{ $attributes->merge(['class' => $isTab, 'id'=>$id]) }}>
    {{ $slot }}
</div>
