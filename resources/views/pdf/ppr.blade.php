<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <title>Preliminary project Report for Assistance under Mukhya Mantri Swablamban Yojana-2019</title>
        <style type="text/css">
            *{font-family: DejaVu Sans, sans-serif !important;font-size: 12px;}
            h3{font-size: large;}
            small{font-size: xx-small;}
            .text-left{text-align: left;}
            .text-right{text-align: right;}
            .text-center{text-align: center;}
            table, th, td{border: 1px solid #333;border-collapse: collapse;}
            th, td{padding: 4px 2px;text-align: left;}
            .w50{width: 50%;}
            .w100{width: 100%;}
            .spacer{height: 1rem;display: block;}
        </style>
    </head>
    <body class="w100">
        @php($data = $application->data)
        <h3 class="text-center">Preliminary project Report for Assistance under Mukhya Mantri Swablamban Yojana - 2019</h3>
        <table class="w100">
            <caption><strong>Appliction ID :</strong> {{ $application->unique_id }}</caption>
            <tbody>
                <tr>
                    <th scope="col" class="w50">Name of Proposed Enterprise</th>
                    <td>M/s {{ $application->getData('enterprise', 'name')}}</td>
                </tr>
                <tr>
                    <th scope="col">Nature of activity</th>
                    <td>{{ $application->activity_type->value }}</td>
                </tr>
                <tr>
                    <th scope="col">Details of Activity</th>
                    <td>{{ $application->activity }}</td>
                </tr>
                <tr>
                    <th scope="col">Constitution (Legal Status)</th>
                    <td>{{ $application->constitution_type->value }}</td>
                </tr>
                <tr>
                    <th scope="col">Location of the proposed enterprise </th>
                    <td>{{ $application->address }}</td>
                </tr>
                <tr>
                    <th scope="col">Applicant</th>
                    <td>{{ $application->owner_address }}</td>
                </tr>
                <tr>
                    <th scope="col">Category</th>
                    <td>
                        {{ implode(', ', array_filter([$application->isSCOrST() ? 'SC/ST' : 'General/OBC', $application->isWomanEnterprise() ? 'Woman Enterprise' : null, $application->isSpeciallyAbledEnterprise() ? 'Divyangjan' : null]))}}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="spacer"></div>
        <table class="w100">
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
                @if(in_array($application->getData('cost', 'land_status'), ['To be Purchased', 'To be Taken on Lease']))
                    <tr>
                        <th scope="col">Land<br /></th>
                        <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'land_cost')) }}</td>
                        <td colspan="2"></td>
                    </tr>
                @endif
                @if(in_array($application->getData('cost', 'building_status'), ['To be Constructed', 'To be Taken on Rent']))
                    <tr>
                        <th scope="col">Cost of building construction/renovation</th>
                        <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'building_cost')) }}</td>
                        <td colspan="2"></td>
                    </tr>
                @endif
                <tr>
                    <th scope="col">Furniture/Fixtures and Other Fixed Assets Cost</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'assets_cost')) }}</td>
                    <th scope="col">Own Contribution <small>({{ $application->getData('finance', 'own_contribution') }}%)</small></th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->own_contribution_amount) }}</td>
                </tr>
                <tr>
                    <th scope="col">Machinery/Equipments</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'machinery_cost')) }}</td>
                    <th scope="col">Term Loan</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->term_loan) }}</td>
                </tr>
                <tr>
                    <th scope="col">Working Capital</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'working_capital')) }}</td>
                    <th scope="col">Working Capital</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->finance_working_capital) }}</td>
                </tr>
                <tr>
                    <th scope="col">Total</th>
                    <th scope="col" class="text-right">{{ $pageVars['formatter']->format($application->project_cost) }}</th>
                    <th scope="col">Total</th>
                    <th scope="col" class="text-right">{{ $pageVars['formatter']->format($application->own_contribution_amount + $application->term_loan + $application->finance_working_capital) }}</th>
                </tr>
                <tr>
                    <th colspan="2" scope="col">Subsidy Eligible Amount</th>
                    <th colspan="2" scope="col" class="text-right">{{ $pageVars['formatter']->format($application->subsidy_eligible_amount) }}</th>
                </tr>
                <tr>
                    <th scope="col">Subsidy Eligiblity</th>
                    <th scope="col" class="text-right">{{ $application->subsidy_percentage }}%</th>
                    <th scope="col">Subsidy Amount <small>(Estimated)</small><br /><small>* 60% + 40% Subsidy Installments Amount</small></th>
                    <th scope="col" class="text-right">{{ $pageVars['formatter']->format($application->subsidy_amount) }}<br /><small>({{ $pageVars['formatter']->format($application->subsidy_amount * 0.6) }} + {{ $pageVars['formatter']->format($application->subsidy_amount * 0.4) }})</small></th>
                </tr>
            </tbody>
        </table>
        <p><strong>I hereby certify that:</strong></p>
        <ul class="list-group">
            <li class="list-group-item">I am a Bonafied Himachali.</li>
            <li class="list-group-item">My age is as per the policy guidelines.</li>
            <li class="list-group-item">I and my spouse have not taken the benefit of this scheme yet.</li>
            <li class="list-group-item">I am applying for new project and not for the expansion of existing unit.</li>
            <li class="list-group-item">Information and documents submitted by me are true.</li>
            <li class="list-group-item">Unit location will not changed without prior permission from General Manager, DIC.</li>
            <li class="list-group-item">I've read the notifications vide which MMSY-2019 was notified.</li>
        </ul>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <p class="text-right">
            <small>({{$application->getData('owner', 'name')}})</small><br />
            Signature of Applicant
        </p>
    </body>
</html>