@props(['class', 'id', 'action', 'method'])

<x-card.card>
    <x-card.card-header>
        <h6 class="mb-1">{{ $title ?? __('Mark application') }}</h6>
        <p class="text-sm mb-0">{{ $description ?? __('Here you can update application.') }}</p>
    </x-card.card-header>
    <x-card.card-body class="px-3">
        <form {{ $attributes->merge(['id' => $id ?? '', 'class' => $class ?? '' ]) }} method="{{ $method ? 'POST' : 'GET' }}" action="{{$action}}">
            @csrf @if($method=='PUT') @method('PUT') @endif
            <div class="row">
                {{ $form }}
            </div>
        </form>
    </x-card.card-body>
</x-card.card>
