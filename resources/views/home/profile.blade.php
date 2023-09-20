@extends('layouts.admin')

@section('title', $title ?? 'Profile')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('dashboard.pendency') }}">{{ __('Applications') }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('Profile') }}</li>
        </ol>
    </nav>
@endsection

@php($user = auth()->user())
@section('content')
    <form method="POST" class="container" action="{{ route('save.profile') }}">
        @csrf
        <fieldset>
            <legend>Profile</legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Name *</label>
                        <input type="text" autofocus required name="name" autocomplete="name" value="{{ old('name', $user->name) }}" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" autocomplete="email" {{ $user->email ? 'readonly' : '' }} value="{{ old('email', $user->email) }}" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Mobile</label>
                        <input type="tel" name="mobile" autocomplete="mobile" {{ $user->mobile ? 'readonly' : '' }} value="{{ old('mobile', $user->mobile) }}" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </fieldset>
    </form>
    <form class="container" method="POST" action="{{ route('save.credentials') }}">
        @csrf
        <input type="text" autocomplete="username" value="{{ $user->email }}" class="d-none" />
        <fieldset>
            <legend>Password</legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Password *</label>
                        <input type="password" autocomplete="new-password" required name="password" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" autocomplete="new-password" required name="password_confirmation" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </div>
        </fieldset>
    </form>
    @php($roles = $user->roles)
    @if($roles->count() > 0)
        <p>
            Role(s):
            @php($badgeClasses = ['primary', 'secondary', 'info', 'success', 'danger', 'warning'])
            @foreach($roles as $i => $role)
                <span class="badge bg-{{$badgeClasses[$i]}} text-white">
                    {{ $role->name }}
                    @php($roleDistricts = $role->districts)
                    @if($roleDistricts)
                        ({{implode(', ', $roleDistricts->pluck('name')->toArray())}})
                    @endif
                    @php($roleBankBranches = $role->bank_branches)
                    @if($roleBankBranches)
                        ({{implode(', ', $roleBankBranches->pluck('details')->toArray())}})
                    @endif
                </span>
            @endforeach
        </p>
    @endif
@endsection
