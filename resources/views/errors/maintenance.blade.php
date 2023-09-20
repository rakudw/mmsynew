@extends('errors::minimal')

@section('title', __('Under Maintenance'))

@section('code')
    <p style="text-align: center">
        <strong class="text-warning">Under Maintenance</strong>
    </p>
@endsection

@section('message')
    <p>Sorry for the inconvenience but we're performing some maintenance at the moment.</p>
    <hr style="height: 1px;background: rgba(160,174,192,var(--text-opacity));" />
    <p>We'll be back online shortly!</p>
@endsection
