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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row " id="formHolder">
        <div class="col-12">
            @if($applications->count() > 0)
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
                            <a class="btn btn-primary text-white btn-sm"style="margin-left: 30px;" 
                                href="{{ route('application.details', ['application' => $application->id]) }}"
                                download="Application-Details-{{ $application->id }}.pdf"><em class="fa fa-download"></em> Print / Download</a>
                            <a class="btn btn-primary text-white btn-sm"style="margin-left: 30px;" href="{{ route('application.newedit', ['application' => $application, 'Is_Preview' => 'Yes',]) }}">
                                 Preview Your Application</button>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Applicant ID:</th>
                        <td>MMSY-{{ $application->id }}</td>
                        <th>Applicant Name:</th>
                        <td>{{ $application->data->owner->name }}</td>
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
                        @if ($application->status->id == '317')
                            <th>Subsidy 40% Date</th>
                            <td>
                                {{$application->data->old_40_subsidy->fs_created}}
                            </td>
                            <tr>
                                <th>Subsidy 40% Amount</th>
                                <td>
                                    {{$application->data->old_40_subsidy->subsidy_40}}
                                </td>
                            </tr>
                        @endif
                    </tr>
                </tbody>
            </table>
            @endforeach
            @else
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Enter Any of Your Email, Number, or Application ID') }}</div>
            
                            <div class="card-body">
                            <form method="POST" action="{{ route('application.login') }}">
                                @csrf

                                {{-- Single Input Field with Combined Placeholder and Title --}}
                                <div class="text-center">
                                    <div class="form-group">
                                        <label for="combinedInput">{{ __('Email, Number, and Application ID') }}</label>
                                        <input type="text" class="form-control" id="combinedInput" name="combinedInput"
                                            placeholder="{{ __('Email, Number, or Application ID') }}"
                                            title="{{ __('Email, Number, and Application ID') }}" required>
                                    </div>

                                    {{-- OTP Input Field (Initially Hidden) --}}
                                    <div class="form-group otp-input" style="display: none;">
                                        <label for="otp">{{ __('OTP') }}</label>
                                        <input type="text" class="form-control" id="otp" name="otp" required>
                                    </div>
                                    
                                    {{-- Send OTP Button --}}
                                    <button type="button" class="btn btn-primary send-otp-btn">{{ __('Send OTP') }}</button>
                                    
                                    {{-- Submit Button (Initially Hidden) --}}
                                    <button type="submit" class="btn btn-primary submit-btn" style="display: none;">{{ __('Submit') }}</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Application Status and Note -->
    @if(count($applications))
    <div class="text-center">
        
    @php
        $printedRemarks = []; 
    @endphp

    @if(isset($application->timelines) && count($application->timelines) > 0)
        <div style="margin-bottom: 20px">
        <h5 style="background-color: rgb(255, 138, 48); padding: 10px; color: white">REMARKS</h5>

            @foreach($application->timelines as $key => $timeline)
                @if(isset($timeline->remarks) && !in_array($timeline->remarks, $printedRemarks))
                    @php
                        $printedRemarks[] = $timeline->remarks; 
                    @endphp
                        
                        <span style="background-color: rgb(255, 138, 48); padding: 5px 10px; color: white; border-radius: 5px; display:inline-block; margin:10px ">{{ $timeline->remarks }} </span> &nbsp; &nbsp; @if($key < count($application->timelines) - 1) => @endif
                @endif
            @endforeach
        </div>
    @else
        <p>No status updates available.</p>
    @endif

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
        @if($application->status->id == 302 || $application->status->id == 301)
        <a href="{{ route('application.newedit', ['application' => $application,]) }}">
            <button class="btn btn-primary">Edit Your Application</button>
        </a>
        @endif
    </div>
    @endif
@endsection

<style>
    tr.sub_row th {
        background: white !important;
        border-right: 1px solid black !important;
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