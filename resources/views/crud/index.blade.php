@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $pageVars['title'] ?? __('Dashboard') }}</li>
        </ol>
        <p class="mt-2">
            <a class="btn btn-secondary" href="{{ route('crud.create', $pageVars['class']) }}">
                <em class="fa fa-plus-circle"></em>
                Create New
            </a>
            @if($pageVars['class'] == 'bank-branch')
                <a class="btn btn-secondary" href="{{ route('crud.bulk') }}">
                    <em class="fa fa-plus-circle"></em>
                    Bulk Upload
                </a>
            @endif
        </p>
    </nav>
@endsection

@section('content')
    @if(!empty($controller->getFilters()))
        <div class="row">
            <div class="col-md-12">
                <x-cards.card>
                    <x-cards.header class="px-md-4 py-md-3">
                        <h5 class="mb-0">Filters</h5>
                    </x-cards.header>
                    <x-cards.body>
                        <form class="row">
                            @foreach($controller->getFilters() as $column)
                                <x-crud.select :model="$controller->getDummy()" :element="$controller->getFilterElement($column)" />
                            @endforeach
                            <div class="mb-3 col-md-3">
                                <label>&nbsp;</label>
                                <div class="input-group input-group-outline my-3 is-valid is-filled">
                                    <label for="search_element" class="form-label">Search</label>
                                    <input type="search" value="{{ request()->get('search') }}" class="form-control  is-valid  " name="search" id="search_element" autocomplete="off" placeholder="search term" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                    <em class="fa fa-search"></em>
                                    Search
                                </button>
                            </div>
                        </form>
                    </x-cards.body>
                </x-cards.card>
            </div>
        </div>
    @endif
    <div class="row align-items-center">
        <div class="col-md-12">
            <x-cards.card>
                <x-cards.header class="px-md-4 py-md-3">
                    <h5 class="mb-0">{{ $pageVars['title'] }}</h5>
                    <p class="text-sm mb-0">
                        List 
                    </p>
                </x-cards.header>
                <x-cards.body>
                    @if(count($models) > 0)
                        @php($ignoreColumns = ['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'])
                        @php($firstModel = $models[0])
                        @php($columns = array_keys($firstModel->toArray()))
                        <div class="col-12">
                            <x-table.table class="table table-flush align-items-center text-sm">
                                <x-table.head>
                                    <x-table.tr>
                                        <x-table.th></x-table.th>
                                        @foreach($columns as $column)
                                            @if(!in_array($column, $ignoreColumns))
                                                <x-table.th>{{ $controller->displayHeader($column) }}</x-table.th>
                                            @endif
                                        @endforeach
                                    </x-table.tr>
                                </x-table.head>
                                <x-table.body>
                                    @foreach($models as $model)
                                        <x-table.tr>
                                            <x-table.th>
                                                <a href="{{ route('crud.edit', ['class' => $pageVars['class'], 'id' => $model->id]) }}" class="mx-3 text-decoration-none btn" data-bs-toggle="tooltip" data-bs-original-title="Edit {{ $pageVars['modelName'] }}">
                                                    <em class="fa fa-pen"></em>
                                                </a>
                                            </x-table.th>
                                            @foreach($columns as $column)
                                                @if(!in_array($column, $ignoreColumns))
                                                    <x-table.td>
                                                        @if(is_null($model[$column]))
                                                            <em>NULL</em>
                                                        @else
                                                            {{ $controller->displayModelColumn($model, $column) }}
                                                        @endif
                                                    </x-table.td>
                                                @endif
                                            @endforeach
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
                    {!! $links !!}
                </x-cards.footer>
            </x-cards.card>
        </div>
    </div>
@endsection
