<div class="col-md-12 my-4">
    <x-card.card>
        <x-card.card-header>
            <h6 class="mb-1">{{ $title ?? __('Mark application') }}</h6>
            <p class="text-sm mb-0">{{ $description ?? __('Here you can update application.') }}</p>
        </x-card.card-header>
        <x-card.card-body class="px-3">
            <div class="row">
                {{ $form }}
            </div>
        </x-card.card-body>
    </x-card.card>
</div>
