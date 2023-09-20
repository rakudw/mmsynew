@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">{{ $type->value }} Regions</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $pageVars['title'] ?? __('Dashboard') }}</li>
        </ol>
        <p class="mt-2">
            <a class="btn btn-secondary" href="{{ route('regions.create', ['type' => request()->route()->parameter('type')]) }}">
                <em class="fa fa-plus-circle"></em>
                Create New
            </a>
        </p>
    </nav>
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <x-cards.card>
                <x-cards.header class="px-md-4 py-md-3">
                    <h5 class="mb-0">{{ $type->value }}</h5>
                    <p class="text-sm mb-0">
                        List 
                    </p>
                </x-cards.header>
                <x-cards.body>
                    @if($regions->count() > 0)
                        <div class="col-12">
                            <x-table.table class="table table-flush align-items-center text-sm">
                                <x-table.head>
                                    <x-table.tr>
                                        <x-table.th class="text-end">Sr. No.</x-table.th>
                                        <x-table.th>Name</x-table.th>
                                        <x-table.th>{{ $type == \App\Enums\RegionTypeEnum::PANCHAYAT_WARD ? 'Parent Block' : 'Parent District' }}</x-table.th>
                                        <x-table.th></x-table.th>
                                    </x-table.tr>
                                </x-table.head>
                                <x-table.body>
                                    @foreach($regions as $i => $region)
                                        <x-table.tr>
                                            <x-table.th class="text-end">{{ ((request()->get('page', 1) - 1) * 15) + $i + 1 }}.)</x-table.th>
                                            <x-table.td>{{ $region->name }}</x-table.td>
                                            <x-table.td>{{ $region->name }}</x-table.td>
                                            <x-table.td></x-table.td>
                                        </x-table.tr>
                                    @endforeach
                                </x-table.body>
                            </x-table.table>
                        </div>
                    @else
                        <div class="alert alert-warning">Nothing to display here!</div>
                    @endif
                </x-cards.body>
                <x-cards.footer>
                    {!! $regions->links() !!}
                </x-cards.footer>
            </x-cards.card>
        </div>
    </div>
@endsection
