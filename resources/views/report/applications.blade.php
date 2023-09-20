@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                {{ $pageVars['title'] ?? __('Banks Overview') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">{{ ucfirst(request()->route()->parameter('type')) }} Applications</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @include('shared.datatables.css')
@endsection

@section('scripts')
    @include('shared.datatables.js')
@endsection
