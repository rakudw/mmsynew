@extends('layouts.admin')

@section('title', $title ?? 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('Dashboard') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Dashboard') }}</h6>
    </nav>
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <x-cards.card>
                <x-cards.header class="px-md-4 py-md-3">
                    <form class="row">
                        <div class="col-12">
                            <h6>Filters</h6>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" name="status_id">
                                <option value="">-- Status --</option>
                                @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                                    @if($status->id() > 302)
                                        <option value="{{ $status->id() }}" @selected(request()->get('status_id') == $status->id())>{{ $status->value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input placeholder="Search" type="search" class="form-control" name="search" value="{{ request()->get('search') }}" />
                        </div>
                        <div class="col-md-4 text-center">
                            <button class="btn btn-primary" type="submit">Apply</button>
                        </div>
                    </form>
                    <hr />
                    <h5 class="mb-0">{{ __("Application Details") }}</h5>
                </x-cards.header>
                <x-cards.body>
                    <div class="col-12">
                        <x-application.list :applications="$applications" />
                    </div>
                </x-cards.body>
                <x-cards.footer>
                    {{ $applications->links() }}
                </x-cards.footer>
            </x-cards.card>
        </div>
    </div>
@endsection
