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
            <table class="table">
                <tbody>
                    
                    <tr bgcolor="#E36E2C">
                        <td colspan="6">
                            <div align="center" class="style1">
                                <h5><b>{{ $application->status->name }}</b></h5>
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
                            <div class="card-header">Enter Any of Your Email, Number, or Application ID</div>
            
                            <div class="card-body">
                                <form method="POST" action="{{ route('application.login') }}">
                                    @csrf
            
                                    {{-- Single Input Field with Combined Placeholder and Title --}}
                                    <div class="form-group">
                                        <label for="combinedInput">Email, Number, and Application ID</label>
                                        <input type="text" class="form-control" id="combinedInput" name="combinedInput" placeholder="Email, Number, or Application ID" title="Email, Number, and Application ID" required>
                                    </div>
            
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
<style>
    tr.sub_row th {
        background: white !important;
        border-right: 1px solid black !important;
    }
    
</style>