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
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $form->name }}</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-3" role="tablist">
                            @foreach ($formDesigns as $formDesign)
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1"
                                        href="{{ route('application.edit', ['application' => $application->id, 'form' => $form->id, 'formDesignId' => $formDesign->id]) }}"
                                        role="tab" aria-selected="false">
                                        <span class="material-icons align-middle mb-1">
                                            badge
                                        </span>
                                        {{ $formDesign->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-icons"
                                    role="tab" aria-controls="code" aria-selected="false">
                                    <span class="material-icons align-middle mb-1">
                                        laptop
                                    </span>
                                    <strong>Documents</strong>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @php($canSubmit = true)
                    @foreach ($formDocumentTypes as $formDocumentType)
                        @php($show = true)
                        @if($formDocumentType->extras && property_exists($formDocumentType->extras, 'condition'))
                            @php(eval('$show = ' . $formDocumentType->extras->condition . ';'))
                        @endif
                        @if($show)
                            <form method="post"
                                action="{{ route('application.upload', ['application' => $application->id, 'documentType' => $formDocumentType->document_type_id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            {{ $formDocumentType->documentType->name }}{{ $formDocumentType->is_required ? '*' : '' }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="file" name="file"
                                                    accept="{{ $formDocumentType->documentType->mime }}"
                                                    {{ $formDocumentType->is_required ? 'required="required"' : '' }} />
                                            </div>
                                            <div class="col-sm-6">
                                                <button type="submit" class="btn btn-secondary">Upload</button>
                                            </div>
                                            @if ($formDocumentType->extras && property_exists($formDocumentType->extras, 'message'))
                                                <div class="col-12">
                                                    {!! sprintf($formDocumentType->extras->message, $application->id) !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div @class([
                                        'card-footer',
                                        'bg-warning' => $formDocumentType->is_required && !isset($applicationDocuments[$formDocumentType->document_type_id]),
                                        'bg-success text-light' => isset($applicationDocuments[$formDocumentType->document_type_id])
                                    ])>
                                        @if (isset($applicationDocuments[$formDocumentType->document_type_id]))
                                            <p><strong>Download Uploaded File:</strong> 
                                            <a target="_blank"
                                                    href="{{ route('application.document', ['document' => $applicationDocuments[$formDocumentType->document_type_id]->document_id]) }}">{{ $applicationDocuments[$formDocumentType->document_type_id]->document_name }}</a>
                                            </p>
                                        @else
                                            @if ($formDocumentType->is_required)
                                                @php($canSubmit = false)
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </form>
                            <hr />
                        @endif
                    @endforeach
                    @foreach($allApplicationDocuments as $applicationDocument)
                        @if(!$applicationDocument->document_type_id)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ $applicationDocument->document_name }}</h5>
                                </div>
                                <div class="card-footer">
                                    <p><strong>Download Uploaded Document:</strong> <a target="_blank"
                                            href="{{ route('application.document', ['document' => $applicationDocument->document_id]) }}">{{ $applicationDocument->document_name }}</a>
                                    </p>
                                    <p><a class="btn btn-danger" data-confirm="true" data-confirm-title="Are you sure you want to delete the document?"
                                            href="{{ route('application.document-remove', ['application' => $application->id, 'document' => $applicationDocument->document_id]) }}">Remove Document</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <form method="post"
                        action="{{ route('application.upload-generic', ['application' => $application->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Any Other File</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-outline my-3">
                                            <label for="documentName" class="form-label">Document Name/Short Description
                                                *</label>
                                            <input class="form-control" name="document_name" type="text"
                                                required="required" id="documentName" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="file" name="file"
                                            accept="{{ $formDocumentType->documentType->mime }}"
                                            {{ $formDocumentType->is_required ? 'required="required"' : '' }} />
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-secondary">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr />

                    @can('submit', $application)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('application.edit', ['application' => $application->id]) }}"
                                            class="btn bg-gradient-primary w-100 my-4 mb-2">
                                            <em class="material-icons opacity-10">remove_red_eye</em>
                                            Cross Check Application
                                        </a>
                                    </div>
                                    @if ($canSubmit)
                                        <hr />
                                        <div class="col-12">
                                            <p class="lead">Bank Selected: <em>{{ $application->bank_branch_details }}</em></p>
                                        </div>
                                        <div class="col-12">
                                            <form method="post"
                                                action="{{ route('application.submit', ['application' => $application->id]) }}">
                                                @csrf
                                                <div class="form-check mt-3">
                                                    <label class="custom-control-label" for="agreementCheckbox">
                                                        <input class="form-check-input" type="checkbox" id="agreementCheckbox"
                                                            required="required" />
                                                        I hereby certify that the information in the application is as per the guidelines of MMSY and the applicant and his/her spouse has not taken the benefits under this scheme already.
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">
                                                    <em class="material-icons opacity-10">verified_user</em>
                                                    Submit Application
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
