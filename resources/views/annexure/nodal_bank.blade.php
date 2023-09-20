<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <title>Nodal Bank Information under Mukhya Mantri Swavlamban Yojna</title>
        <style type="text/css">
            *{font-family: DejaVu Sans, sans-serif !important;font-size: 14px;}
            h3{font-size: large;}
            small{font-size: 10px;}
            .text-left{text-align: left;}
            .text-right{text-align: right;}
            .text-center{text-align: center;}
            .text-justify{text-align: justify;}
            table.bordered, table.bordered th, table.bordered td{border: 1px solid #333;border-collapse: collapse;}
            th, td{padding: 5px 3px;text-align: left;}
            .w50{width: 50%;}
            .w100{width: 100%;}
            .spacer{height: 1rem;display: block;}
        </style>
    </head>
    <body class="w100">
        <p class="text-center"><strong>Nodal Bank Information</strong></p>
        <table class="w100">
            <tbody>
                <tr>
                    <th scope="row">Application ID</th>
                    <td class="text-right">{{ $application->unique_id }}</td>
                    <th scope="row">District</th>
                    <td class="text-right">{{ $application->region->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Communication Address</th>
                    <td class="text-right">{{ $application->owner_short_address }}</td>
                    <th scope="row">Name of the Applicant</th>
                    <td class="text-right">{{ $application->getData('owner', 'name') }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ $application->activity_type->name }}</th>
                    <td colspan="3">{{ $application->activity }}</td>
                </tr>
            </tbody>
        </table>
        <div class="spacer"></div>
        <table class="w100 bordered">
            <tbody>
                <tr>
                    <th colspan="2" scope="row">Project Cost as approved by DLC</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->project_cost) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of Loan sanctioned by Bank</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'term_loan')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Subsidy admissible @</th>
                    <td colspan="2" class="text-right">{{ $application->getData('subsidy', 'percentage') }}%</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Total amount of eligible subsidy</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('subsidy', 'amount')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of 60% Capital subsidy</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('subsidy', 'amount60')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Proposed Employment</th>
                    <td colspan="2" class="text-right">{{ $application->getData('enterprise', 'employment') }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of CGTMSE Fee (if any)</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'cgtmse_fee')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Own contribution (Margin Money)</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'own_contribution')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Branch Details</th>
                    <td colspan="2" class="text-right">{{ $application->bank_branch_details }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">UTR/Transaction Number</th>
                    <td colspan="2" class="text-right">{{ $application->data->subsidy ? $application->data->subsidy->utrno60 : '' }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Transaction Date</th>
                    <td colspan="2" class="text-right">{{ $application->data->subsidy ? $application->data->subsidy->date60 : '' }}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
