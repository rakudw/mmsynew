@extends('layouts.admin')

@section('title', 'Banner Details')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('banners.index') }}">Banners</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Banner Details</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <x-cards.card>
                <x-cards.header class="px-md-4 py-md-3">
                    <h5 class="mb-0">Banner Details</h5>
                </x-cards.header>
                <x-cards.body>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Title:</strong> {{ $banner->title }}</p>
                            <p><strong>Description:</strong> {{ $banner->description }}</p>
                            <p><strong>Status:</strong> {{ $banner->status }}</p>
                            <p><strong>Year:</strong> {{ $banner->year }}</p>
                            <p><strong>Type:</strong> {{ $banner->type }}</p>
                            <p><strong>Action:</strong> {{ $banner->action }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Image:</strong></p>
                            <img src="{{ $banner->image_path }}" alt="Banner Image" class="img-fluid">
                        </div>
                    </div>
                </x-cards.body>
            </x-cards.card>
        </div>
    </div>
@endsection
