<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <base href="{{ asset('/') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | {{ config('app.name', 'MMSY') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/scss/fontawesome.scss', 'resources/scss/admin.scss', ...(empty($pageVars['assets']['css']) ? [] : $pageVars['assets']['css'])])
    @yield('styles')
</head>

<body class="g-sidenav-show  bg-gray-200">

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">

                <nav
                    class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid ps-2 pe-0">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="/">
                            {{ config('app.name') }}
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon mt-2">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-2 active" aria-current="page"
                                        href="/">
                                        <i class="fa fa-home opacity-6 text-dark me-1"></i>
                                        Home
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-6 col-md-4 col-sm-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h3 class="text-white font-weight-bolder text-center mt-2 mb-0">MUKHYA MANTRI SWAVALAMBAN YOJANA</h3>
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">GOVT. OF HIMACHAL PRADESH</h4>
                                    <h5 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="list-unstyled text-light">
                                            @foreach ($errors->all() as $error)
                                                <li>{!! $error !!}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form data-key="{{ request()->session()->get('_key') }}" method="POST" action="{{ route('login.request') }}">
                                    @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <label for="identity" class="form-label">{{ __('Email Address or Mobile') }}</label>
                                        <input id="identity" data-mobile-otp="{{ setting('is_mobile_otp_available', null, false) ? 'true' : 'false' }}" type="text" class="form-control @error('identity') is-invalid @enderror @error('mobile') is-invalid @enderror" name="identity" autocomplete="username" value="{{ old('identity') }}" required autofocus />
                                        @error('identity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="d-none" id="passwordBox">
                                        <div class="input-group input-group-outline mb-3">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" name="password" required />
                                        </div>
                                        <div class="form-check form-switch d-flex align-items-center mb-3 is-filled">
                                            <input class="form-check-input" type="checkbox" id="showPassword" />
                                            <label class="form-check-label mb-0 ms-3" for="showPassword">Show Password</label>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group input-group-outline mb-3 d-none" id="otpBox">
                                        <label for="otpCode" class="form-label">{{ __('OTP Code') }}</label>
                                        <input id="otpCode" type="number" min="100000" max="999999" autocomplete="nickname" class="form-control @error('otpCode') is-invalid @enderror" name="otpCode" />
                                        @error('otpCode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="text-center" id="optionButtonBox">
                                        <div class="row">
                                            <div class="col-12">
                                                <hr />
                                                <a href="{{ route('login.applicant') }}">Applicant Login</a>
                                                <h3>Login Using</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" id="showPasswordButton" class="btn bg-gradient-primary w-100 my-4 mb-2"><em class="fa-solid fa-key"></em> {{ __('Password') }}</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" id="showOtpButton" class="btn bg-gradient-primary w-100 my-4 mb-2" data-url="{{ route('otp.request') }}">
                                                    <em class="fa-sharp fa-solid fa-comment-sms"></em> {{ __('OTP') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center d-none">
                                        <label for="captcha">{{ $captchaQuestion }} = ?</label>
                                        <button type="button" class="btn btn-theme-primary" id="captchaRefreshButton">
                                            <em class="fa fa-refresh"></em>
                                        </button>
                                    </div>
                                    <div class="input-group input-group-outline mb-3 d-none">
                                        <label for="captcha" class="form-label">{{ __('Security Code') }}</label>
                                        <input id="captcha" type="text" required="required"  class="form-control mt-1 @error('captcha') is-invalid @enderror" name="captcha" required="required" />
                                        @error('captcha')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="text-center d-none">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign
                                            in</button><br />
                                        <a href="{{ route('login') }}" class="btn bg-gradient-secondary w-100 my-4 mb-2">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Scripts -->
    @vite(['resources/ts/admin.ts', 'resources/ts/login.ts', ...(empty($pageVars['assets']['js']) ? [] : $pageVars['assets']['js'])])
    @yield('scripts')
</body>

</html>
