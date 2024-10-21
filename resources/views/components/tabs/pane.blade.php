@props(['active', 'title'])

@php
    $classes = ($active ?? false)
                ? 'tab-pane fade show active'
                : 'tab-pane fade';
    $slug = \Illuminate\Support\Str::slug($title)
@endphp
<div id="{{$slug}}" {{ $attributes->merge(['class' => $classes]) }} role="tabpanel" aria-labelledby="{{$slug}}-tab">
    {{ $slot }}
</div>
