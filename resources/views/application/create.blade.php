@extends('layouts.admin')

@section('title', $title ?? 'Application for Approval')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('applications.list') }}">{{ __('Applications') }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                {{ $title ?? __('Application for Approval') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Application for Approval') }}</h6>
    </nav>
@endsection

@section('content')

    <div class="row " id="formHolder">
        <div class="col-12">
            <x-form :application="$application" :design="$formDesign" :form="$form" :formDesigns="$formDesigns" />
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        window.APPLICATION = {
            TAB: '{{ $formDesign->slug }}'
        };
        @if ($application)
            window.APPLICATION.DATA = {!! json_encode($application->data) !!};
        @else
            window.APPLICATION.DATA = {};
        @endif
    </script>
@endsection