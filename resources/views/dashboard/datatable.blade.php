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
                    <h5 class="mb-0">{{ __("Application Details") }}</h5>
                </x-cards.header>
                <x-cards.body>
                    {{ $dataTable->table() }}
                </x-cards.body>
            </x-cards.card>
        </div>
    </div>
@endsection

@section('scripts')
    {{ $dataTable->scripts() }}
@endsection