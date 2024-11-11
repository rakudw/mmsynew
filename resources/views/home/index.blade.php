{{-- @extends('layouts.new_app')  Uncomment for old layout--}} 
@extends('layouts.main')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('contents')
    @include('shared.front-end.main.banner-section')
    @include('shared.front-end.main.main')
@endsection
