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
    @if(isset($applications) && $applications->count() >=1)
        <form action="{{ route('schedule.meeting') }}" method="post" class="row align-items-center">
            @csrf
            <div class="col-md-12">
                <x-cards.card>
                    <x-cards.header class="px-md-4 py-md-3">
                        <h5 class="mb-0">{{ $title ?? __("Applications") }}</h5>
                        <p class="text-sm mb-0">
                            {{ $description ?? __('List of the applications.') }}
                        </p>
                    </x-cards.header>
                    <x-cards.body>
                        <x-application.list :applications="$applications" :status="true" :selectedApplications="[]" />
                    </x-cards.body>
                    <x-cards.footer>
                        {{ $applications->links() }}
                    </x-cards.footer>
                </x-cards.card>
            </div>
        </form>
    @else
        <div class="col-md-12">
            <x-cards.card>
                <x-cards.header class="px-md-4 py-md-3">
                    <h5 class="mb-0">{{ $title ?? __("Applications") }}</h5>
                    <p class="text-sm mb-0">
                        {{ $description ?? __('Sorry! There is no application till now.') }}
                    </p>
                </x-cards.header>
            </x-cards.card>
        </div>
    @endif
@endsection
