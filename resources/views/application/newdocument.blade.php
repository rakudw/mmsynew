@extends('layouts.applicant')

@section('title', $title ?? 'Application for Approval')

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
<style>
    .alert-danger{
        --bs-alert-bg: #e36e2c;
        background-color: #e36e2c !important;
    }
</style>
@section('content')
@include('shared.front-end.applicant_header')

<div class="row " id="formHolder">
    <div class="col-12">
        <x-forms.document :application="$application" :doctype="$Documenttype" :allApplicationDocuments="$allApplicationDocuments" />
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Function to check if all required inputs are filled
    function checkRequiredInputs() {
        var requiredInputs = $('input[required]');
        console.log('requiredInputs',requiredInputs)
        for (var i = 0; i < requiredInputs.length - 1; i++) {
            if (!requiredInputs[i].value) {
                return false;
            }
        }
        return true;
    }
    $('#finalSubmissionButton').prop('disabled', !checkRequiredInputs());
    // Enable/disable the final submission button based on required input completion
    $('input').on('input', function() {
        var finalSubmissionButton = $('#finalSubmissionButton');
        finalSubmissionButton.prop('disabled', !checkRequiredInputs());
    });
   
    $('#previewButton').on('click', function() {
    $('#applicationModal').modal('show');
});
});
</script>
@endsection

