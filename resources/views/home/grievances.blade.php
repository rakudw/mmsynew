@extends('layouts.applicant')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('content')
    @include('shared.front-end.applicant_header')

    <div class="container">
        <h4 class="text-center mt-4 mb-4"> User Name : Rakesh  </h4>
        <h4 class="text-center mt-4 mb-4"> Email will be sent on Submit your GRIEVANCES  </h4>
    </div>
@endsection
<style>
    tr{
        line-height: 50px;
    }
</style>
@section('scripts')
@endsection
