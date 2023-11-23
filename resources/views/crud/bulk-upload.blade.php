@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Dashboard')

@section('content')
<div class="row align-items-center">
    <div class="col-md-6">
        <form action="{{ route('crud.upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <label class="form-label m-2" for="file">Upload Excel File:</label>
            <input class="form-control m-2" type="file" name="file" id="file" accept=".xlsx, .xls">
            <button type="submit" class=" m-2  btn btn-success">Upload</button>
        </form>
    </div>
</div>
@endsection