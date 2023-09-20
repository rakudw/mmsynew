@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Application for Approval')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('crud.list', $pageVars['class']) }}">{{ str($pageVars['modelName'])->plural() }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $pageVars['title'] ?? __('Application for Approval') }}</li>
        </ol>
        @if($model->id)
            <h6 class="font-weight-bolder mb-0">@if (isset($model->name))
                                                    {{ $model->name }}
                                                @elseif(isset($model->title))
                                                    {{ $model->title }}
                                                @else
                                                    {{ $model->description }}
                                                @endif</h6>
        @endif
    </nav>
@endsection

@section('content')
    <div class="row" id="formHolder">
        <div class="col-12">
            <x-crud.form :model="$model" />
        </div>
    </div>
@endsection