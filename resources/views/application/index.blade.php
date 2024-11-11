@extends('layouts.admin')

@section('title', $title ?? 'Applications')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('applications.list') }}">{{ __("Applications") }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('Applications') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Applications') }}</h6>
    </nav>
@endsection

@section('content')
    <div class="d-sm-flex justify-content-md-end">
        <div>
            <a href="{{ route("application.create", 1) }}" class="btn btn-icon bg-gradient-primary">
                New application
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-cards.card class="shadow-sm">
                <x-cards.header class="card-header py-2">
                    <h3>List of Applications</h3>
                </x-cards.header>
                <x-cards.body>
                    <x-application.list :applications="$applications" />
                </x-cards.body>
            </x-cards.card>
        </div>
    </div>
@endsection
