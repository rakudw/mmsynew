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
                        <td>{{ $application->data->enterprise->activity_type_id }}</td>
                        <th>Aadhar No:</th>
                        <td>{{ $application->data->owner->aadhaar }}</td>
                        <th>Project Cost:</th>
                        <td>{{ $application->getProjectCostAttribute() }}</td>
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
                                    <div class="form-group">
                                        <label for="combinedInput">{{ __('Email, Number, and Application ID') }}</label>
                                        <input type="text" class="form-control" id="combinedInput" name="combinedInput" placeholder="{{ __('Email, Number, or Application ID') }}" title="{{ __('Email, Number, and Application ID') }}" required>
                                    </div>
            
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
        <button>{{ $application->status->id == 302 ? 'Complete' : 'Edit'}} Your Application</button>
        @endif
    </div>
@endsection

<style>
    tr.sub_row th {
        background: white !important;
        border-right: 1px solid black !important;
    }
</style>
