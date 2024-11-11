@isset($loop)
    @php
        $title = $title ?? 'Define title';
        $slug = \Illuminate\Support\Str::slug($title);
    @endphp
<li class="nav-item" role="presentation">
    <a class="nav-link mb-0 px-0 py-1 @if($loop->first) active @endif" id="{{ $slug }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $slug }}" type="button"
       role="tab" aria-controls="{{ $slug }}" aria-selected="@if($loop->first) true @endif">
        @if(\Illuminate\Support\Str::startsWith($icon, 'fa'))
            <i class="{{ $icon }}"></i>
        @else
            <span class="material-icons px-2 align-middle mb-1">
            {{ $icon ?? '' }}
        </span>
        @endif
        {{ $title ?? 'no-name' }}
    </a>
</li>
@else
    <li class="nav-item" role="presentation">
        {{ $slot }}
    </li>
@endisset
