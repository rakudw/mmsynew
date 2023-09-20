@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Application for Approval')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('banners.index') }}">Banners</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Create New Banner</li>
        </ol>
        @if($model->id)
            <h6 class="font-weight-bolder mb-0">{{ $model->name }}</h6>
        @endif
    </nav>
@endsection

@section('content')
    <div class="row" id="formHolder">
        <div class="col-12">
            <x-crud.form :model="$model" />

            <!-- Customized Form for Banner -->
            <form action="{{ route('banners.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description"></textarea>
                </div>
                <div class="form-group">
                    <label for="image_path" class="form-label">Image Path</label>
                    <input type="text" name="image_path" id="image_path" class="form-control" placeholder="Enter image path">
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" name="status" id="status" class="form-control" placeholder="Enter status">
                </div>
                <div class="form-group">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="Enter year">
                </div>
                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" name="type" id="type" class="form-control" placeholder="Enter type">
                </div>
                <div class="form-group">
                    <label for="action" class="form-label">Action</label>
                    <input type="text" name="action" id="action" class="form-control" placeholder="Enter action">
                </div>
                <button type="submit" class="btn btn-primary">Create Banner</button>
            </form>
        </div>
    </div>
@endsection
