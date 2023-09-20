@extends('layouts.app')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('contents')
    @include('shared.front-end.slider')
    @include('shared.front-end.mmsy_tips')
    @include('shared.front-end.our_schemes')
    @include('shared.front-end.commitee')
    @include('shared.front-end.aboutus')
    @include('shared.front-end.details')
    @include('shared.front-end.important_lnks')
@endsection
