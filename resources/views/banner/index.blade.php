@extends('layouts.admin')

@section('title', 'Banner List')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Banner List</li>
        </ol>
        <p class="mt-2">
            <a class="btn btn-secondary" href="{{ route('banners.create',$pageVars['class']) }}">
                <em class="fa fa-plus-circle"></em>
                Create New
            </a>
        </p>
    </nav>
@endsection

@section('content')
    @if(!empty($controller->getFilters()))
        <!-- Filters Form -->
    @endif
    <div class="row align-items-center">
        <div class="col-md-12">
            <x-cards.card>
                <x-cards.header class="px-md-4 py-md-3">
                    <h5 class="mb-0">Banner List</h5>
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
                                                <x-table.th>{{ Str::title(str_replace('_', ' ', $column)) }}</x-table.th>
                                            @endif
                                        @endforeach
                                    </x-table.tr>
                                </x-table.head>
                                <x-table.body>
                                    @foreach($models as $model)
                                        <x-table.tr>
                                            <x-table.th>
                                                <a href="{{ route('banners.edit', $model->id) }}" class="mx-3 text-decoration-none btn" data-bs-toggle="tooltip" data-bs-original-title="Edit Banner">
                                                    <em class="fa fa-pen"></em>
                                                </a>
                                            </x-table.th>
                                            @foreach($columns as $column)
                                                @if(!in_array($column, $ignoreColumns))
                                                    <x-table.td>
                                                        @if(is_null($model[$column]))
                                                            <em>NULL</em>
                                                        @else
                                                            {{ $model->$column }}
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