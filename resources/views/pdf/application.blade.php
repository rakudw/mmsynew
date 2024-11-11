@extends('pdf.base')

@section('title', $title ?? __("Application Details"))

@section('style')
    <style type="text/css">
        .col-3{width: 33%}
        .col-4{width: 25%}
        .col-6{width: 50%}
        .col-9{width: 66%}
        .mh-200{max-height: 200px;}
        .badge{padding: 3px 2px;border-radius: 3%;display: inline-block;}
        .page-break-before{page-break-before: always;}
        .page-break-after{page-break-after: always;}
    </style>
@endsection

@section('content')
    <table class="w100">
        <caption><strong>Application Details - Mukhya Mantri Swavlamban Yojana</strong></caption>
        <tbody>
            <tr>
                <td class="col-3 text-center">
                    @php($dp = $application->documents()->where('document_type_id', 5)->first())
                    @if($dp)
                        <img src="data:image/{{ $dp->mime }};base64,{{ base64_encode($dp->content) }}" alt="M/s {{ $application->getData('enterprise', 'name') }}" class="mh-200 badge" />
                    @endif
                </td>
                <th scope="row">
                    <p>
                        M/s {{ $application->getData('enterprise', 'name') }}
                        <br />
                        {{ $application->address }}
                    </p>
                </th>
            </tr>
        </tbody>
    </table>
    <table class="w100 bordered">
        <caption></caption>
        <tbody>
            <tr>
                <td class="col-6">
                    Applicant:
                    <strong>
                        {{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }}
                        {{ $application->getData('owner', 'name') }}
                    </strong>
                </td>
                <td>
                    Activity:
                    <strong>{{ $application->activity_type->value }}<br />&mdash; <em>{{ $application->activity }}</em></strong>
                </td>
            </tr>
            <tr>
                <td>
                    Constitution (Legal Status):
                    <strong>{{ $application->constitution_type->value }}</strong>
                </td>
                <td>
                    Employment Generation:
                    <strong>{{ $application->getData('enterprise', 'employment') }}</strong>
                </td>
            </tr>

            <tr>
                <td>
                    Applicant:
                    <strong>
                        {{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }}
                        {{ $application->getData('owner', 'name') }}
                    </strong>
                </td>
                <td>
                    Contact:
                    @if ($application->getData('owner', 'mobile'))
                        <strong>&#9742; {{ $application->getData('owner', 'mobile') }}</strong>
                    @endif
                    @if ($application->getData('owner', 'mobile') && $application->getData('owner', 'email'))
                        <br />
                    @endif
                    @if ($application->getData('owner', 'email'))
                        <strong>&#9993; {{ $application->getData('owner', 'email') }}</strong>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Gender:
                    <strong>{{ $application->getData('owner', 'gender') }}</strong>
                </td>
                <td rowspan="4">
                    Address:
                    <strong>{{ $application->owner_address }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    Social Category:
                    <strong>{{ $application->social_category->value }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    Specially Abled:
                    <strong>{{ $application->getData('owner', 'is_specially_abled') }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    Aadhaar Number:
                    <strong>
                        ********{{ substr($application->getData('owner', 'aadhaar'), -4) }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    Date of Birth:
                    <strong>{{ $application->getData('owner', 'birth_date') }} ({{ $application->applicant_age }} years)</strong>
                </td>
                <td>
                    PAN Number:
                    <strong>{{ $application->getData('owner', 'pan') }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    @if ($application->constitution_type != \App\Enums\ConstitutionTypeEnum::PROPRIETORSHIP)
        <table class="w100 bordered page-break-after">
            <caption><strong>Other Partners/Shareholders</strong></caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Category</th>
                    <th>Specially Abled</th>
                    <th>Aadhaar Number</th>
                    <th>Mobile</th>
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
                            {{ $application->getData('owner', 'partner_birth_date')[$loop->index] }} ({{ $application->calculateAge($application->getData('owner', 'partner_birth_date')[$loop->index]) }} years)
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
                            &#9742; {{ $application->getData('owner', 'partner_mobile')[$loop->index] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <table class="w100 bordered">
        @php($data = $application->data)
        <caption><strong>Cost of Project and Means of Finance (In Rs.)</strong></caption>
        <thead>
            <tr>
                <th scope="row">Project Cost</th>
                <th scope="row">Amount (Rs.)</th>
                <th scope="row">Means of Finance</th>
                <th scope="row">Amount (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="col">Land<br /></th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->getData('cost', 'land_cost')) }}</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th scope="col" colspan="2">
                    Building</th>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th scope="col">&bull; Building Construction/Renovation</th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->getData('cost', 'building_cost')) }}
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th scope="col">&bull; Furniture/Fixtures and Other Fixed Assets</th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->getData('cost', 'assets_cost')) }}
                </td>
                <th scope="col">Own Contribution <small>({{ $application->getData('finance', 'own_contribution') }}%)</small></th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->own_contribution_amount) }}
                </td>
            </tr>
            <tr>
                <th scope="col">Machinery/Equipments</th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->getData('cost', 'machinery_cost')) }}
                </td>
                <th scope="col">Term Loan</th>
                <td class="text-right">{{ $pageVars['formatter']->format($application->term_loan) }}</td>
            </tr>
            <tr>
                <th scope="col">Working Capital</th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->getData('cost', 'working_capital')) }}
                </td>
                <th scope="col">Working Capital</th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->finance_working_capital) }}
                </td>
            </tr>
            <tr>
                <th scope="col">Total</th>
                <th scope="col" class="text-right">
                    {{ $pageVars['formatter']->format($application->project_cost) }}</th>
                <th scope="col">Total</th>
                <th scope="col" class="text-right">
                    {{ $pageVars['formatter']->format($application->own_contribution_amount + $application->term_loan + $application->finance_working_capital) }}</th>
            </tr>
            <tr>
                <th scope="row" colspan="4"></th>
            </tr>
            <tr>
                <th scope="row">Subsidy Eligible Amount</th>
                <td class="text-right">{{ $pageVars['formatter']->format($application->subsidy_eligible_amount) }}</td>
                <th scope="row" class="text-right">Subsidy Applicable</th>
                <td class="text-right">
                    {{ $pageVars['formatter']->format($application->subsidy_amount) }}
                    <small>({{ $application->subsidy_percentage }}%)</small><br />
                    <small>({{ $pageVars['formatter']->format($application->subsidyAmount(60)) }} + {{ $pageVars['formatter']->format($application->subsidyAmount(40)) }})
                </td>
            </tr>
        </tbody>
    </table>

    <table class="w100 bordered">
        <tbody>
            <tr>
                <th scope="row">Furniture/Fixtures and Other Fixed Assets Detail</th>
                <td>{{ $application->getData('cost', 'assets_detail') }}</td>
                <th scope="row">Machinery/Equipments Detail</th>
                <td>{{ $application->getData('cost', 'machinery_detail') }}</td>
            </tr>
            <tr>
                <th scope="row" colspan="2">Bank Branch</th>
                <td colspan="2">{{ $application->bank_branch_details }}</td>
            </tr>
        </tbody>
    </table>

    @if($application->getData('loan', 'account_number'))
        <table class="w100 bordered">
            <caption><strong>Loan Details</strong></caption>
            <tbody>
                <tr>
                    <th scope="row">Own Contribution</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'own_contribution')) }}</td>
                    <th scope="row">Term Loan</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'term_loan')) }}</td>
                </tr>
                <tr>
                    <th scope="row">Working Capital</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'working_capital')) }}</td>
                    <th scope="row">Sanction Date</th>
                    <td class="text-right">{{ $application->getData('loan', 'sanction_date') }}</td>
                </tr>
                <tr>
                    <th scope="row">Disbursed Amount</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'disbursed_amount')) }}</td>
                    <th scope="row">Disbursement Date</th>
                    <td class="text-right">{{ $application->getData('loan', 'disbursement_date') }}</td>
                </tr>
                <tr>
                    <th scope="row" colspan="2">Transient Account Number for Disbursement of Subsidy</th>
                    <td class="text-right" colspan="2">{{ $application->getData('loan', 'account_number') }}</td>
                </tr>
            </tbody>
        </table>
    @endif
@endsection