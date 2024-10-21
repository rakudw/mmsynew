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
    @if(isset($formDesigns) && $formDesigns->count() >=1)
        <div class="row" data-masonry='{"percentPosition": true }'>
            @foreach($formDesigns as $formDesign)
                <div class="col-6">
                    <x-cards.card>
                        <x-cards.header class="card-header p-3 pt-2" index="true">
                            <h5 class="text-white">{{ $formDesign->name }}</h5>
                        </x-cards.header>
                        <x-cards.body>
                            <x-table.table class="table align-items-center mb-0">
                                @foreach($formDesign->validations as $key => $value)
                                    <x-table.body>
                                        @if(count(explode('.*', $key)) == 1)
                                            @php($class = strpos($value, 'exists:') !== false ? explode(',',explode('exists:', $value, 2)[1])[0] : '')
                                            <x-table.tr>
                                                <x-table.td class="text-sm font-weight-normal mb-0"><strong>{{ strtoupper( str_replace(['_', ' id'], [' ', ''], $key)) }}</strong></x-table.td>
                                                <x-table.td class="text-sm text-end font-weight-normal mb-0">{{ strpos($value, 'exists:') !== false ? ($application->getData($formDesign->slug, $key) ? (($val = $class::find($application->getData($formDesign->slug, $key))) ? $val->name : 'Unknown') : 'Unknown') : $application->getData($formDesign->slug, $key) }}</x-table.td>
                                            </x-table.tr>
                                        @endif
                                    </x-table.body>
                                @endforeach
                            </x-table.table>
                        </x-cards.body>
                    </x-cards.card>
                </div>
            @endforeach
        </div>
    @endisset
@endsection
