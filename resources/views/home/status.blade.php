@extends('layouts.applicant')

@section('title', $title ?? 'Application Status')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('applications.list') }}">{{ __('Applications') }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                {{ $title ?? __('Application for Approval') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Application for Approval') }}</h6>
    </nav>
@endsection

@section('content')
    @include('shared.front-end.applicant_header')
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <base href="{{ asset('/') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | {{ config('app.name', 'MMSY') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Styles -->
    @yield('styles')
    </head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row " id="formHolder">
        <div class="col-12">
            @if($applications)
            @foreach ($applications as $application)
            <table class="table" style="margin-top: 35px;">
                <tbody>
                    
                    <tr bgcolor="#E36E2C">
                        <td colspan="6">
                            <div align="center" class="style1">
                                <h5><b>{{ __('Application Status') }}</b></h5>
                            </div>
                            @if($application->status->id == '302')
                            <div align="center" class="style1">
                                <h5>Click <a href="{{ route('application.newedit', [
                                    'application' => $application,
                                ]) }}"> here</a> to complete your application</h5>
                            </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Applicant ID:</th>
                        <td>MMSY-{{ $application->id }}</td>
                        <th>Applicant Name:</th>
                        <td>{{ $application->name }}</td>
                        <th>Pan No:</th>
                        <td>{{ $application->data->owner->pan }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td>{{ $application->data->owner->birth_date }}</td>
                        <th>Mobile No:</th>
                        <td>{{ $application->data->owner->mobile }}</td>
                        <th>Gender:</th>
                        <td>{{ $application->data->owner->gender }}</td>
                    </tr>
                    <tr>
                        <th>Industry Type:</th>
                        <td>
                            @if ($application->data->enterprise->activity_type_id == 201)
                                Manufacturing
                            @elseif ($application->data->enterprise->activity_type_id == 202)
                                Servicing
                            @elseif ($application->data->enterprise->activity_type_id == 203)
                                Trading
                            @else
                                Unknown
                            @endif
                        </td>
                        <th>Aadhar No:</th>
                        <td>{{ $application->data->owner->aadhaar }}</td>
                        <th>Project Cost:</th>
                        <td>{{ $application->getProjectCostAttribute() }}</td>
                    </tr>
                    <tr>
                        <th>Activity Name</th>
                        <td>
                            @if ($activities->count() > 0)
                                @foreach ($activities as $activity)
                                    @if ($activity->id == $application->data->enterprise->activity_id)
                                        {{ $activity->name }}
                                    @endif
                                @endforeach
                            @else
                                Unknown
                            @endif
                        </td>
                        <th>Activity ID</th>
                        <td>
                            @if ($activities->count() > 0)
                                @foreach ($activities as $activity)
                                    @if ($activity->id == $application->data->enterprise->activity_id)
                                        {{ $activity->id }}
                                    @endif
                                @endforeach
                            @else
                                Unknown
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @endforeach
            @else
            <main class="main-content  mt-0">
                    <div class="page-header align-items-start min-vh-100">
                        <span class="mask opacity-6"></span>
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-lg-6 col-md-4 col-sm-12 mx-auto">
                                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                            <div class="bg-gradient-primary1 shadow-primary border-radius-lg py-3 pe-1">
                                                <h3 class="text-white font-weight-bolder text-center mt-2 mb-0">MUKHYA MANTRI SWAVALAMBAN YOJANA</h3>
                                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">GOVT. OF HIMACHAL PRADESH</h4>
                                                <h5 class="text-white font-weight-bolder text-center mt-2 mb-0">Applicant Sign in</h5>
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
                                                <div class="form-group">
                                                    <label for="identity">{{ __('Enter you Email / Mobile / Application ID') }}</label>
                                                    <input id="identity" data-mobile-otp="{{ setting('is_mobile_otp_available', null, false) ? 'true' : 'false' }}" type="text" class="form-control @error('identity') is-invalid @enderror @error('mobile') is-invalid @enderror" name="identity" placeholder="Email,Phone,Application No." autocomplete="username" value="{{ old('identity') }}" required autofocus />
                                                    @error('identity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="d-none" id="passwordBox">
                                                    <div class="input-group mb-3">
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
                                                <div class="form-group d-none" id="otpBox">
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
                                                        <div class="col-12 d-none">
                                                            <hr />
                                                            <a href="{{ route('login.applicant') }}">Applicant Login</a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" style=" background: #e36e2c; color:white;width: 80%;" id="showOtpButton" class="btn bg-gradient-primary1 w-80 my-4 mb-2" data-url="{{ route('otp.request') }}">
                                                                <em class="fa-sharp fa-solid fa-comment-sms"></em> {{ __('Generate OTP') }}</button>
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
                                                    <input id="captcha" type="text" required="required" class="form-control mt-1 @error('captcha') is-invalid @enderror" name="captcha" required="required" />
                                                    @error('captcha')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="text-center d-none">
                                                    <button type="submit" style=" background: #e36e2c; color:white; width: 80%;" class="btn bg-gradient-primary1  my-4 mb-2">Sign
                                                        in</button><br />
                                                    <a href="{{ route('login.applicant') }}" class="btn bg-gradient-secondary w-100 my-4 mb-2">Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            @endif
        </div>
    </div>

    <!-- Application Status and Note -->
    @if(count($applications))
    <div class="text-center">
        <h5 style="background-color: rgb(255, 138, 48); padding: 10px; color: white">{{ $application->status->name }}</h5>
        @if($application->status->id == 306)
            <p>Your application is submitted and pending at DIC. You will get notifications for further actions.</br> आपका आवेदन सबमिट किया गया है और DIC में लंबित है। आपको आगे की कार्रवाई के लिए सूचनाएं मिलेंगी।</p>
        @endif
        @if($application->status->id == 302)
            <p>Your application is not completed yet please click on below button to complete it.</br> आपका आवेदन अभी पूरा नहीं हुआ है, कृपया नीचे दिए गए बटन पर क्लिक करके इसे पूरा करें।</p>
        @endif
        <hr style="background-color: rgb(255, 138, 48);">
        @if($application->status->id == 302 || $application->status->id == 305)
        <a href="{{ route('application.newedit', ['application' => $application,]) }}">
            <button class="btn btn-primary">{{ $application->status->id == 302 ? 'Complete' : 'Edit'}} Your Application</button>
        </a>
        @endif
        @if($application->status->id == 302 || $application->status->id == 305 || $application->status->id == 301)
        <a href="{{ route('application.newedit', ['application' => $application,]) }}">
            <button class="btn btn-primary">Edit Your Application</button>
        </a>
        @endif
    </div>
    
    @endif
    @vite(['resources/ts/admin.ts', 'resources/ts/otplogin.ts', ...(empty($pageVars['assets']['js']) ? [] : $pageVars['assets']['js'])])
    @yield('scripts')
@endsection

<style>
    tr.sub_row th {
        background: white !important;
        border-right: 1px solid black !important;
    }
    .bg-gradient-primary1{
        background: #e36e2c;
    }
    .form-control:focus {
        outline: none !important;
        box-shadow: none !important;
    }
    #identity, #otpCode{
        /* text-align: center; */
        margin: auto;
        margin-top: 10px;
        width: 80%;
        height: 40px;
    }
    label {
        display: inline-block;
        text-align: left;
        margin-left: auto;
        width: 80%;
    }
    .swal2-container.swal2-top-right.swal2-backdrop-show{
        position: absolute;
        top: 50%;
        left: 37%;
        z-index: 999;
        background: orange;
        width: 28%;
        margin: auto;
        text-align: center;
    }
</style>
@section('scripts')
<script src="https://sso.hp.gov.in/nodeapi/iframe/iframe.js" defer=""></script>
<script>
$(document).ready(function() {
    @if (!Auth::check())
            // getIframeSSO("10000074")
        @endif
    // Function to show OTP input field and hide Send OTP button
    function showOtpInput() {
        $('.otp-input').show();
        $('.send-otp-btn').hide();
    }

    // Function to show Submit button after OTP input
    function showSubmitButton() {
        $('.submit-btn').show();
    }

    // Event listener for Send OTP button click
    $('.send-otp-btn').on('click', function() {
        // Add your logic here to send OTP via email or SMS

        // Once OTP is sent, show OTP input field
        showOtpInput();
    });

    // Event listener for form submission
    $('form').on('submit', function(e) {
        // Prevent form submission if OTP input is not visible
        if ($('.otp-input').is(':hidden')) {
            e.preventDefault();
            alert('Please enter OTP first.');
        }
    });

    // Event listener for OTP input blur (assuming OTP validation is successful)
    $('#otp').on('blur', function() {
        showSubmitButton();
    });
});
</script>
@endsection
