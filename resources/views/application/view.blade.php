@extends('layouts.admin')

@section('title', $title ?? $application->name)

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('applications.list') }}">{{ __('Applications') }}</a></li>
            <li class="breadcrumb-item text-dark active" aria-current="page">M/s
                {{ $application->getData('enterprise', 'name') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">M/s
            {{ $application->getData('enterprise', 'name') }}</h6>
    </nav>
@endsection

@section('content')
    @php($applicationDocumentId = $applicationDocument ? $applicationDocument->id : 0)
    <div class="card">
        <div class="card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                @if ($applicationDocument)
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                M/s {{ $application->getData('enterprise', 'name') }}
                            </h5>
                            <p class="mb-0 font-weight-normal">
                                {{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }}
                                {{ $application->getData('owner', 'name') }}
                            </p>
                        </div>
                    </div>
                @endif
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper end-0 text-end">
                        @if ($applicationDocument)
                            <a class="btn btn-primary text-white btn-sm"
                                href="{{ route('application.document', $applicationDocument->document_id) }}"
                                download="{{ $applicationDocument->document->name }}"><em class="fa fa-download"></em>
                                Download</a>
                            <button type="button" class="btn btn-primary text-white btn-sm"
                                onclick="javascript:document.querySelector('#documentIframe').contentWindow.print();"><em
                                    class="fa fa-print"></em> Print</button>
                        @elseif($annexure)
                            <a class="btn btn-primary text-white btn-sm"
                                href="{{ route('application.annexure', ['application' => $application->id, 'annexure' => $annexure]) }}"
                                download="Annexure-{{ $annexure }}-{{ $application->id }}.pdf"><em class="fa fa-download"></em>
                                Download</a>
                            <button type="button" class="btn btn-primary text-white btn-sm"
                                onclick="javascript:document.querySelector('#documentIframe').contentWindow.print();"><em
                                    class="fa fa-print"></em> Print</button>
                        @else
                            <a class="btn btn-primary text-white btn-sm"
                                href="{{ route('application.details', ['application' => $application->id]) }}"
                                download="Application-Details-{{ $application->id }}.pdf"><em class="fa fa-download"></em> Print / Download</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs">
                        @foreach ($tabs as $doc)
                            <li class="nav-item">
                                <a class="nav-link {{ $doc['id'] == $applicationDocumentId && is_null($annexure) ? 'active' : '' }}"
                                    aria-current="{{ $doc['id'] == $applicationDocumentId && is_null($annexure) ? 'page' : '' }}"
                                    href="{{ $doc['id'] == $applicationDocumentId && is_null($annexure) ? 'javascript:;' : route('application.view', ['application' => $application->id, 'applicationDocument' => $doc['id'] > 0 ? $doc['id'] : null, 'annexure' => 'none']) }}">{{ $doc['name'] }}</a>
                            </li>
                        @endforeach
                        @if($application->status_id > \App\Enums\ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id())
                            <li class="nav-item">
                                <a class="nav-link {{ $annexure == 'a' ? 'active' : '' }}"
                                    aria-current="{{ $annexure == 'a' ? 'page' : '' }}"
                                    href="{{ $annexure == 'a' ? 'javascript:;' : route('application.view', ['application' => $application->id, 'annexure' => 'a']) }}">Annexure-A</a>
                            </li>
                        @endif
                        @if($application->status_id > \App\Enums\ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())
                            <li class="nav-item">
                                <a class="nav-link {{ $annexure == 'sanction' ? 'active' : '' }}"
                                    aria-current="{{ $annexure == 'sanction' ? 'page' : '' }}"
                                    href="{{ $annexure == 'sanction' ? 'javascript:;' : route('application.view', ['application' => $application->id, 'annexure' => 'sanction']) }}">Bank Sanction</a>
                            </li>
                        @endif
                        @if($application->status_id > \App\Enums\ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())
                            <li class="nav-item">
                                <a class="nav-link {{ $annexure == 'nodal_bank' ? 'active' : '' }}"
                                    aria-current="{{ $annexure == 'nodal_bank' ? 'page' : '' }}"
                                    href="{{ $annexure == 'nodal_bank' ? 'javascript:;' : route('application.view', ['application' => $application->id, 'annexure' => 'nodal_bank']) }}">Nodal Bank Information</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="row" id="printable">
                <div class="col-12">
                    @if (!$applicationDocument && !$annexure)
                        <div class="row gx-4 mb-2 mt-2 px-3">
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        M/s {{ $application->getData('enterprise', 'name') }}
                                    </h5>
                                    <p class="mb-0 font-weight-normal">
                                        {{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }}
                                        {{ $application->getData('owner', 'name') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row gx-4 mb-2 mt-2 px-3">
                        <div class="col-12 mb-md-0 mb-4">
                            <div class="card card-plain">
                                <div class="card-body">
                                    @if (!$applicationDocumentId && !$annexure)
                                        <div class="row mb-2 clearfix">
                                            <div class="col-md-8 mb-md-0 mb-4">
                                                <ul class="list-group">
                                                    <li class="list-group-item border-0 mb-2 bg-gray-100 border-radius-lg">
                                                        <div class="row clearfix">
                                                            <div class="col">
                                                                <div class="mb-2 mx-2">
                                                                    Location:
                                                                    <strong class="text-dark font-weight-bold ms-sm-2">
                                                                        {{ $application->address }}
                                                                    </strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">Constitution (Legal Status): <strong
                                                                        class="text-dark font-weight-bold ms-sm-2">{{ $application->constitution_type->value }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-2 mx-2">Nature of Activity: <strong
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $application->activity_type->value }}</strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">Activity: <strong
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $application->activity }}</strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">Employment Generation: <strong
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $application->getData('enterprise', 'employment') }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item border-0 mb-2 bg-gray-100 border-radius-lg">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-2 mx-2">Applicant: <strong
                                                                        class="text-dark font-weight-bold ms-sm-2">{{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }}
                                                                        {{ $application->getData('owner', 'name') }}</strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">Gender: <strong
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $application->getData('owner', 'gender') }}</strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">Social Category: <strong
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $application->social_category->value }}</strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">Specially Abled: <strong
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $application->getData('owner', 'is_specially_abled') }}</strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">
                                                                    Aadhaar Number:
                                                                    <strong class="text-dark font-weight-bold ms-sm-2">
                                                                        ********{{ substr($application->getData('owner', 'aadhaar'), -4) }}
                                                                    </strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">
                                                                    Date of Birth:
                                                                    <strong class="text-dark font-weight-bold ms-sm-2">
                                                                        {{ $application->getData('owner', 'birth_date') }} <small title="At the time of application submission.">({{ $application->applicant_age }} years)</small>
                                                                    </strong></span>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-2 mx-2">
                                                                    Mobile:
                                                                    <strong class="text-dark font-weight-bold ms-sm-2">
                                                                        <a
                                                                            href="tel:{{ $application->getData('owner', 'mobile') }}">{{ $application->getData('owner', 'mobile') }}</a>
                                                                    </strong>
                                                                </div>
                                                                @if ($application->getData('owner', 'email'))
                                                                    <div class="mb-2 mx-2">
                                                                        Email:
                                                                        <strong class="text-dark font-weight-bold ms-sm-2">
                                                                            <a
                                                                                href="mailto:{{ $application->getData('owner', 'email') }}">{{ $application->getData('owner', 'email') }}</a>
                                                                        </strong>
                                                                    </div>
                                                                @endif
                                                                <div class="mb-2 mx-2">
                                                                    Address:
                                                                    <strong class="text-dark font-weight-bold ms-sm-2">
                                                                        {{ $application->owner_address }}
                                                                    </strong>
                                                                </div>
                                                                <div class="mb-2 mx-2">
                                                                    PAN Number:
                                                                    <strong
                                                                        class="text-dark font-weight-bold ms-sm-2 text-uppercase">
                                                                        {{ $application->getData('owner', 'pan') }}
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <p class="lead text-center">{{ $application->bank_branch_details }}</p>
                                                @if(\App\Helpers\ApplicationHelper::getBranchEmail($application->data->finance->bank_branch_id))
                                                    <p class="lead text-center">
                                                        <span>Branch Emails: </span>
                                                        @foreach (\App\Helpers\ApplicationHelper::getBranchEmail($application->data->finance->bank_branch_id) as $data) 
                                                       [ <b> {{ $data['email'] }} </b> ]
                                                        @endforeach
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <x-application.timeline :application="$application" />
                                            </div>
                                            <div class="col-12 clearfix">&nbsp;</div>
                                        </div>
                                        @if ($application->isAFirm())
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center mb-0">
                                                            <caption class="text-center">Partners</caption>
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Name
                                                                    </th>
                                                                    <th
                                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Gender
                                                                    </th>
                                                                    <th
                                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                        Date of Birth
                                                                    </th>
                                                                    <th
                                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Category
                                                                    </th>
                                                                    <th
                                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Specially Abled
                                                                    </th>
                                                                    <th
                                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Aadhaar Number
                                                                    </th>
                                                                    <th
                                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Mobile
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($application->getData('owner', 'partner_name') as $partner)
                                                                    <tr>
                                                                        <td>
                                                                            {{ $partner }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $application->getData('owner', 'partner_gender')[$loop->index] }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $application->getData('owner', 'partner_birth_date')[$loop->index] }} <small title="At the time of application submission.">({{ $application->calculateAge($application->getData('owner', 'partner_birth_date')[$loop->index]) }} years)</small>
                                                                        </td>
                                                                        <td>
                                                                            {{ \App\Enums\SocialCategoryEnum::fromId($application->getData('owner', 'partner_social_category_id')[$loop->index])->value }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $application->getData('owner', 'partner_is_specially_abled')[$loop->index] }}
                                                                        </td>
                                                                        <td class="align-middle text-center text-sm">
                                                                            ********{{ substr($application->getData('owner', 'partner_aadhaar')[$loop->index], -4) }}
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                            <a href="tel:{{ $application->getData('owner', 'partner_mobile')[$loop->index] }}">{{ $application->getData('owner', 'partner_mobile')[$loop->index] }}</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row mb-2">
                                            <div class="col">
                                                <div class="table-responsive">
                                                    <table class="table align-items-center mb-0 table-sm text-sm">
                                                        @php($data = $application->data)
                                                        <caption class="text-center">Cost of Project and Means of Finance (In Rs.)
                                                        </caption>
                                                        <thead>
                                                            <tr>
                                                                <th scope="row">Project Cost</th>
                                                                <th scope="row">Amount (Rs.)</th>
                                                                <th scope="row">Means of Finance</th>
                                                                <th scope="row">Amount (Rs.)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(in_array($application->getData('cost', 'land_status'), ['To be Purchased', 'To be Taken on Lease']))
                                                                <tr>
                                                                    <th scope="col">Land<br /></th>
                                                                    <td class="text-end">
                                                                        {{ $pageVars['formatter']->format($application->getData('cost', 'land_cost')) }}</td>
                                                                    <td colspan="2"></td>
                                                                </tr>
                                                            @endif
                                                            @if(in_array($application->getData('cost', 'building_status'), ['To be Constructed', 'To be Taken on Rent']))
                                                                <tr>
                                                                    <th scope="col" colspan="2">
                                                                        Building</th>
                                                                    <td colspan="2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">&bull; Building Construction/Renovation</th>
                                                                    <td class="text-end">
                                                                        {{ $pageVars['formatter']->format($application->getData('cost', 'building_cost')) }}
                                                                    </td>
                                                                    <td colspan="2"></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <th scope="col">Furniture/Fixtures and Other Fixed Assets</th>
                                                                <td class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->getData('cost', 'assets_cost')) }}
                                                                </td>
                                                                <th scope="col">Own Contribution <small>({{ $application->getData('finance', 'own_contribution') }}%)</small></th>
                                                                <td class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->own_contribution_amount) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Machinery/Equipments</th>
                                                                <td class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->getData('cost', 'machinery_cost')) }}
                                                                </td>
                                                                <th scope="col">Term Loan</th>
                                                                <td class="text-end">{{ $pageVars['formatter']->format($application->term_loan) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Working Capital</th>
                                                                <td class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->getData('cost', 'working_capital')) }}
                                                                </td>
                                                                <th scope="col">Working Capital</th>
                                                                <td class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->finance_working_capital) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Total</th>
                                                                <th scope="col" class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->project_cost) }}</th>
                                                                <th scope="col">Total</th>
                                                                <th scope="col" class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->own_contribution_amount + $application->term_loan + $application->finance_working_capital) }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" colspan="4"></th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Subsidy Eligible Amount</th>
                                                                <td class="text-end">{{ $pageVars['formatter']->format($application->subsidy_eligible_amount) }}</td>
                                                                <th scope="row" class="text-end">Subsidy Applicable <small>(Estimated)</small></th>
                                                                <td class="text-end">
                                                                    {{ $pageVars['formatter']->format($application->subsidy_amount) }}
                                                                    <small>({{ $application->subsidy_percentage }}%)</small><br />
                                                                    <small>({{ $pageVars['formatter']->format($application->subsidyAmount(60)) }} + {{ $pageVars['formatter']->format($application->subsidyAmount(40)) }})
                                                                </td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <p>
                                                    <strong>Furniture/Fixtures and Other Fixed Assets Detail:</strong>
                                                    {{ $application->getData('cost', 'assets_detail') }}<br />
                                                    <strong>Machinery/Equipments Detail:</strong>
                                                    {{ $application->getData('cost', 'machinery_detail') }}
                                                </p>
                                            </div>
                                        </div>
                                        @if(count($oldPortalApplications))
                                            <div class="list-group mb-3">
                                                <a href="javascript:;" class="list-group-item list-group-item-action list-group-item-warning" aria-current="true">
                                                    <div class="fw-bold">Applications on the Old Portal from same Aadhaar Number</div><small>(including spouse and/or partners, if applicable)</small>
                                                </a>
                                                @foreach($oldPortalApplications as $app)
                                                    <a href="https://mmsy.hp.gov.in/old-portal/cse/application/{{ base64_encode($app->a_id) }}" target="_blank" class="list-group-item list-group-item-action"><i class="fa-solid fa-arrow-up-right-from-square"></i> RES{{ $app->a_id }} - <em>{{ $app->a_name }}</em></a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($application->getData('loan', 'account_number'))
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center mb-0 text-sm">
                                                            <caption class="text-center">Loan Details</caption>
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Own Contribution</th>
                                                                    <td class="text-end">{{ $pageVars['formatter']->format($application->getData('loan', 'own_contribution')) }}</td>
                                                                    <th scope="row">Term Loan</th>
                                                                    <td class="text-end">{{ $pageVars['formatter']->format($application->getData('loan', 'term_loan')) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Working Capital</th>
                                                                    <td class="text-end">{{ $pageVars['formatter']->format($application->getData('loan', 'working_capital')) }}</td>
                                                                    <th scope="row">Sanction Date</th>
                                                                    <td class="text-end">{{ $application->getData('loan', 'sanction_date') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Disbursed Amount</th>
                                                                    <td class="text-end">{{ $pageVars['formatter']->format($application->getData('loan', 'disbursed_amount')) }}</td>
                                                                    <th scope="row">Disbursement Date</th>
                                                                    <td class="text-end">{{ $application->getData('loan', 'disbursement_date') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Transient Account Number for Disbursement of Subsidy</th>
                                                                    <td class="text-end">{{ $application->getData('loan', 'account_number') }}</td>
                                                                    <th scope="row">CGTMSE Fee</th>
                                                                    <td class="text-end">{{ $application->getData('subsidy', 'cgtmse_fee') }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($applicationDocumentId)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="ratio ratio-4x3 showLater">
                                                    <iframe title="{{ $applicationDocument->document_name }}"
                                                        id="documentIframe"
                                                        src="{{ route('application.document', $applicationDocument->document_id) }}"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($annexure)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="ratio ratio-4x3 showLater">
                                                    <iframe title="Annexure-{{ $annexure }}"
                                                        id="documentIframe"
                                                        src="{{ route('application.annexure', ['application' => $application->id, 'type' => $annexure]) }}"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php($actions = \App\Helpers\ApplicationHelper::getApplicationActions($application))
    @if(\App\Enums\ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id() != $application->status_id && count($actions))
        <x-forms.form-section action="{{ route('application.status', $application) }}" id="applicationStatus"
            class="my-3" method="PUT" enctype="multipart/form-data">
            <x-slot name="title">
                {{ __('Take Action') }}
            </x-slot>
            <x-slot name="form">
                @if(isset($actions[\App\Enums\ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id()]))
                    <div class="row" data-status-vars="{{ \App\Enums\ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id() }}">
                        <div class="col-12 col-sm-6 mt-sm-0">
                            <label>Physical Inspection Report<br /><br />
                            <x-forms.input-group :dynamic="true">
                                <input type="file" name="applicationDocument[annexure_z]" accept="application/pdf" required="required" />
                            </x-forms.input-group>
                            </label>
                            <div class="col-12">
                                <a href="http://mmsy.hp.gov.in/documents/annexure_b/annexure_z.pdf" download="Annexure-Z.pdf">Download</a>, fill and upload verified <a href="http://mmsy.hp.gov.in/documents/annexure_b/annexure_z.pdf" download="Annexure-Z.pdf">Annexure-Z</a> along with the verified bills.
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mt-sm-0">
                            <x-forms.label class="form-label">&nbsp;</x-forms.label>
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Second Subsidy Installment (40%)</x-forms.label>
                                <x-forms.input type="number" required="required" name="applicationData[subsidy][amount40]" class="form-control w-100" value="{{ old('applicationData[subsidy][amount40]', $application->getData('subsidy', 'amount40', null, $application->subsidyAmount(40))) }}" />
                            </x-forms.input-group>
                        </div>
                    </div>
                @endif
                @if(isset($actions[\App\Enums\ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id()]))
                    <div class="row" data-status-vars="{{ \App\Enums\ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id() }}">
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Own Contribution</x-forms.label>
                                <x-forms.input type="number" required="required" name="applicationData[loan][own_contribution]" value="{{ old('applicationData[loan][own_contribution]', $application->getData('loan', 'own_contribution', null, $application->own_contribution_amount)) }}" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Term Loan</x-forms.label>
                                <x-forms.input type="number" required="required" name="applicationData[loan][term_loan]" class="form-control w-100" value="{{ old('applicationData[loan][term_loan]', $application->getData('loan', 'term_loan', null, $application->term_loan)) }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Working Capital/CC Limit</x-forms.label>
                                <x-forms.input type="number" required="required" name="applicationData[loan][working_capital]" class="form-control w-100" value="{{ old('applicationData[loan][working_capital]', $application->getData('loan', 'working_capital', $application->finance_working_capital)) }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Date of Sanction of Term Loan</x-forms.label>
                                <x-forms.input type="date" data-datepicker-xmax-date="0" data-datepicker-xmin-date="-3" required="required" name="applicationData[loan][sanction_date]" value="{{ old('applicationData[loan][sanction_date]', $application->getData('loan', 'sanction_date')) }}" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Disbursed Amount</x-forms.label>
                                <x-forms.input type="number" required="required" value="{{ old('applicationData[loan][disbursed_amount]', $application->getData('loan', 'disbursed_amount', null, round($application->term_loan * 0.3))) }}" min="{{ round($application->term_loan * 0.3) }}" max="{{ $application->term_loan + $application->finance_working_capital }}" name="applicationData[loan][disbursed_amount]" class="form-control w-100" />
                            </x-forms.input-group>
                            <small class="mt-1">* Should be atleast 30% of the term loan amount!</small>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Date of Disbursement of Term Loan</x-forms.label>
                                <x-forms.input type="date" data-datepicker-xmax-date="0" data-datepicker-xmin-date="-3" required="required" name="applicationData[loan][disbursement_date]" value="{{ old('applicationData[loan][disbursement_date]', $application->getData('loan', 'disbursement_date')) }}" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Transient account number</x-forms.label>
                                <x-forms.input type="text" required="required" name="applicationData[loan][account_number]" value="{{ old('applicationData[loan][account_number]', $application->getData('loan', 'account_number')) }}" class="form-control w-100" />
                            </x-forms.input-group>
                            <small>For release of subsidy</small>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">CGTMSE Fee</x-forms.label>
                                <x-forms.input type="text" required="required" name="applicationData[subsidy][cgtmse_fee]" value="{{ old('applicationData[subsidy][cgtmse_fee]', $application->getData('subsidy', 'cgtmse_fee')) }}" class="form-control w-100" />
                            </x-forms.input-group>
                            <small>If any</small>
                        </div>
                    </div>
                @endif

                @if(isset($actions[\App\Enums\ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id()]))
                    <div class="row" data-status-vars="{{ \App\Enums\ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id() }}">
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.label class="form-label" for="subsidyPercentageElement">Subsidy Percentage Applicable</x-forms.label>

                            <select name="applicationData[subsidy][percentage]" id="subsidyPercentageElement" class="form-control w-100">
                                <option value="25" @selected($application->subsidy_percentage == 25)>25 %</option>
                                <option value="30" @selected($application->subsidy_percentage == 30)>30 %</option>
                                <option value="35" @selected($application->subsidy_percentage == 35)>35 %</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.label class="form-label">&nbsp;</x-forms.label>
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Total Subsidy Amount</x-forms.label>
                                <x-forms.input type="number" required="required" name="applicationData[subsidy][amount]" class="form-control w-100" value="{{ old('applicationData[subsidy][amount]', $application->getData('subsidy', 'amount', null, $application->subsidy_amount)) }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.label class="form-label">&nbsp;</x-forms.label>
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">First Installment (60%)</x-forms.label>
                                <x-forms.input type="number" required="required" name="applicationData[subsidy][amount60]" class="form-control w-100" value="{{ old('applicationData[subsidy][amount60]', $application->getData('subsidy', 'amount60', null, $application->subsidyAmount(60))) }}" />
                            </x-forms.input-group>
                        </div>
                    </div>
                @endif

                @if(isset($actions[\App\Enums\ApplicationStatusEnum::SUBSIDY_60_RELEASED->id()]))
                    <div class="row" data-status-vars="{{ \App\Enums\ApplicationStatusEnum::SUBSIDY_60_RELEASED->id() }}">
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">60% Subsidy Amount</x-forms.label>
                                <x-forms.input type="number" readonly="readonly" required="required" class="form-control w-100" value="{{ $application->subsidyAmount(60) }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">UTR No.</x-forms.label>
                                <x-forms.input type="text" required="required" name="applicationData[subsidy][utrno60]" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Release Date</x-forms.label>
                                <x-forms.input type="date" data-datepicker-xmax-date="0" data-datepicker-xmin-date="-3" required="required" name="applicationData[subsidy][date60]" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                    </div>
                @endif

                @if(isset($actions[\App\Enums\ApplicationStatusEnum::SUBSIDY_40_RELEASED->id()]))
                    <div class="row" data-status-vars="{{ \App\Enums\ApplicationStatusEnum::SUBSIDY_40_RELEASED->id() }}">
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">40% Subsidy Amount</x-forms.label>
                                <x-forms.input type="number" readonly required="required" class="form-control w-100" value="{{ $application->subsidyAmount(40) }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">UTR No.</x-forms.label>
                                <x-forms.input type="text" required="required" name="applicationData[subsidy][utrno40]" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Release Date</x-forms.label>
                                <x-forms.input type="date" data-datepicker-xmax-date="0" data-datepicker-xmin-date="-3" required="required" name="applicationData[subsidy][date40]" class="form-control w-100" />
                            </x-forms.input-group>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6 px-lg-3 px-2 pt-3">
                        <x-roles.select :application="$application" id="applicationStatus" name="status" :actions="$actions" />
                    </div>
                    <div class="col-md-6 px-lg-3 px-2 pt-3">
                        <x-forms.label for="comment">Remarks</x-forms.label>
                        <x-forms.textarea id="comment" rows="3" required="required" maxlength="511" name="comment" rows="2"
                            placeholder="You can enter comment here">{{ old('comment') ?? '' }}</x-forms.textarea>
                    </div>
                    <div class="col-md-12 justify-content-end">
                        <x-forms.button :type="'submit'">Update</x-forms.button>
                    </div>
                </div>
            </x-slot>
        </x-forms.form-section>
	@elseif(\App\Enums\ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id() == $application->status_id)
        {{-- <div class="alert alert-info text-white text-center mt-1" role="alert">
            <strong>This application can be approved or rejected from the <a class="alert-link text-light" href="{{ route('dashboard.meetings') }}">meeting page</a>!</strong>
        </div> --}}
        <x-forms.form-section action="{{ route('application.status', $application) }}" id="applicationStatus"
        class="my-3" method="PUT" enctype="multipart/form-data">
            <x-slot name="title">
            {{ __('Take Action') }}
            </x-slot>
            <x-slot name="form">
                <div class="row">
                    <div class="col-md-6 px-lg-3 px-2 pt-3">
                        <x-forms.label for="applicationStatus" value="{{ $currentStatus ?? __('Take Action') }}" />
                        <x-forms.select id="applicationStatus" name="status" required="required" :showChoose="count($actions) > 1">
                                <option value="{{ \App\Enums\ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id() }}" @selected(old('status') == \App\Enums\ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id())>{{ 'Revert Back to the Bank'}}</option>
                        </x-forms.select>
                        <input name="applicationData[enterprise][revertedBy]" value="dic" type="hidden">
                        <x-forms.input-error for="applicationStatus" class="mt-2" />
                    </div>
                    <div class="col-md-6 px-lg-3 px-2 pt-3">
                        <x-forms.label for="comment">Remarks</x-forms.label>
                        <x-forms.textarea id="comment" rows="3" required="required" maxlength="511" name="comment" rows="2"
                            placeholder="You can enter comment here">{{ old('comment') ?? '' }}</x-forms.textarea>
                    </div>
                    <div class="col-md-12 justify-content-end">
                        <x-forms.button :type="'submit'">Update</x-forms.button>
                    </div>
                </div>
            </x-slot>
        </x-forms.form-section>
        <div class="alert alert-info text-white text-center mt-1" role="alert">
            <strong>Or navigate to <a class="alert-link text-light" href="{{ route('dashboard.meetings') }}">meeting page</a>!</strong>
        </div> 
    @else
        <div class="alert alert-warning text-white text-center mt-1" role="alert">
            <strong>You cannot take any action on this application!</strong>
        </div>
    @endif
@endsection
