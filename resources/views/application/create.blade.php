@extends('layouts.admin')

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

@section('content')
    
    <!-- @if (!$application->id) -->
        <div class="row" id="instructions">
            <div class="col-12">
                <div class="card">
                    <div class="card-header custom">
                        <h4>Instructions and Declaration</h4>
                        <a href="{{ route("login") }}"><button class="btn btn-success">Login To Existing Application</button></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">By clicking the button below you agree to the following:</h5>
                        <ul class="list-group">
                            <li class="list-group-item">&bull; The applicant is a <abbr
                                    title="Bonafide certificate is certification provided to the citizen by the government confirming and testifying their place of residence in the district of Himachal Pradesh.">Bonafied
                                    Himachali</abbr>.</li>
                            <li class="list-group-item">&bull; The age of the applicant is as per the policy requirements.
                            </li>
                            <li class="list-group-item">&bull; The applicant and their spouse have not taken the benefit of
                                this scheme yet.</li>
                            <li class="list-group-item">&bull; The applicant has read the policy document thoroughly.</li>
                            <li class="list-group-item">* <small>The applicant above refers to all the partners/shareholders
                                    collectively or the individual in case of a proprietorship.</small></li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary"
                            onclick="javascript:document.getElementById('formHolder').classList.remove('d-none');document.getElementById('instructions').classList.add('d-none');document.querySelector('input[type=text]').focus();">
                            Continue With New Application</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- @endif -->

    <div class="row {{ $application->id ? '' : 'd-none' }}" id="formHolder">
        <div class="col-12">
            <x-form :application="$application" :design="$formDesign" :form="$form" :formDesigns="$formDesigns" />
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.APPLICATION = {
            TAB: '{{ $formDesign->slug }}'
        };
        @if ($application)
            window.APPLICATION.DATA = {!! json_encode($application->data) !!};
        @else
            window.APPLICATION.DATA = {};
        @endif
    </script>
@endsection
