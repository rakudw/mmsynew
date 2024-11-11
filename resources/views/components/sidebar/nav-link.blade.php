@props(['active'])
@php
    $classes = ($active ?? false)
                ? 'nav-link text-white active bg-gradient-primary'
                : 'nav-link text-white';
@endphp
@isset($hasSubMenu)
    <a data-bs-toggle="collapse" href="#{{ $menuId }}" {{ $attributes->merge(['class' => $classes]) }} aria-controls="{{ $menuId }}" role="button" aria-expanded="false">
        {{ $icon ?? '' }}
        <span class="nav-link-text ms-2 ps-1">{{ $title ?? __("Main Menu")}}</span>
    </a>

    {{ $collapse ?? 'No Collapse found' }}
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            {{ $icon ?? '' }}
        </div>
        <span class="nav-link-text ms-1">{{ $title }}</span>
    </a>
@endisset
