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

<x-card.card-footer>
    <div class="card">
        <div class="card-body">
            <h5 class="font-weight-bolder">Create Agenda Meeting</h5>
            <div class="row mt-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="input-group input-group-dynamic">
                        <label class="form-label">Please Add a Date</label>
                        <input type="date" class="form-control w-100" aria-describedby="dateHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0">
                    <div class="input-group input-group-dynamic">
                        <label class="form-label">Please add Time</label>
                        <input type="time" class="form-control w-100" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0">
                    <div class="input-group input-group-dynamic">
                        <label class="form-label">Chairman</label>
                        <input type="text" class="form-control w-100" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label class="mt-4">Description</label>
                    <p class="form-text text-muted text-xs ms-1 d-inline">
                        (optional)
                    </p>
                    <textarea name=""  class="w-100" placeholder="description is optional or you can explain about meeting..."></textarea>
                </div>
                <div class="">
                    <button type="submit" class="btn bg-gradient-primary mb-0 ms-lg-auto me-lg-0 me-auto">Schedule meeting</button>
                </div>
            </div>
        </div>
    </div>
</x-card.card-footer>
