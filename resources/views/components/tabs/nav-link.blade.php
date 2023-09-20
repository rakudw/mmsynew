@props(['active', 'title'])

@php
    $classes = ($active ?? false)
                ? 'nav-link mb-0 px-0 py-1 active'
                : 'nav-link mb-0 px-0 py-1';
    $slug = \Illuminate\Support\Str::slug($title)
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} id="{{$slug}}-tab" data-bs-toggle="tab" data-bs-target="#{{$slug}}" type="button" role="tab" aria-controls="{{$slug}}" aria-selected="true">
    {{$slot}}
</a>
