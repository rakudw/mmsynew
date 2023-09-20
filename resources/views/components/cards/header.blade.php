@props(['index' => false])

@if($index)
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-primary text-white shadow-primary border-radius-lg py-3 pe-1 ps-3">
            {{ $slot }}
        </div>
    </div>
@else
    <div class="card-header p-0 position-relative">
        <div {{ $attributes->merge(['class' ]) }}>
            {{ $header ?? $slot }}
        </div>
    </div>
@endif
