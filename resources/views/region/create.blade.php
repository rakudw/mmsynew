@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Application for Approval')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('regions.list', ['type' => request()->route()->parameter('type')]) }}">{{ $type->value }} Regions</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $pageVars['title'] ?? __('Application for Approval') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="row align-items-center">
    <div class="col-md-12">
        <x-cards.card>
            <x-cards.header class="px-md-4 py-md-3">
                <h5 class="mb-0">{{ $pageVars['title'] ?? __('Application for Approval') }}</h5>
            </x-cards.header>
            <x-cards.body>
                <form method="post" class="row">
                    @csrf()
                    <div class="mb-3 col-md-12">
                        <div class="input-group input-group-outline my-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" autofocus="on"
                                required="required"
                                name="name" id="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @else is-valid @enderror" />
                        </div>
                        <small>Name of the {{ $type->value }}.</small>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-12">
                        <div class="input-group input-group-outline my-3">
                            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @else is-valid @enderror" required="required">
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" @selected($parent->id == old('parent_id'))>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small>Parent {{ $type == \App\Enums\RegionTypeEnum::PANCHAYAT_WARD ? 'Block/Ward' : 'District' }} of the {{ $type->value }}.</small>
                        @error('parent_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-12">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </x-cards.body>
        </x-cards.card>
    </div>
</div>
@endsection