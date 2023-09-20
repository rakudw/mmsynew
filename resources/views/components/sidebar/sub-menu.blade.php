@props(['active' => false, 'menuId' => ''])

@php
    $classes = ($active ?? false)
                ? 'nav-link text-white collapse show active'
                : 'nav-link text-white collapse';
    $show = ($active ?? false)
                ? 'collapse show'
                : 'collapse';
    $menuId = $menuId ?? \Illuminate\Support\Str::random(8);
@endphp

<a data-bs-toggle="collapse" href="#{{$menuId}}" {{ $attributes->merge(['class' => $classes]) }} aria-controls="{{$menuId}}" role="button" aria-expanded="false">
    {{ $icon ?? $text ?? '' }}
    <span class="nav-link-text ms-2 ps-1">{{$title ?? __("Sub Menu") }}</span>
</a>

<div {{ $attributes->merge(['class' => $show]) }} id="{{$menuId}}">
    {{ $collapse }}
</div>
