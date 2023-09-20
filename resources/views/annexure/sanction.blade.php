<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <title>Sanction Letter under Mukhya Mantri Swavlamban Yojna</title>
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
        <p class="text-center"><strong>Bank Sanction Information</strong></p>
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
            </tbody>
        </table>
        <div class="spacer"></div>
        <table class="w100 bordered">
            <tbody>
                <tr>
                    <th colspan="2" scope="row">Date of Receipt of Proposal to Bank</th>
                    <td colspan="2" class="text-right">{{ $application->timelines->where('new_status_id', App\Enums\ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->last() ? date('Y-m-d', strtotime($application->timelines->where('new_status_id', App\Enums\ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->last()->created_at)) : 'NA' }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Date of Sanction of Case</th>
                    <td colspan="2" class="text-right">{{ $application->getData('loan', 'sanction_date') }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of Term Loan Sanctioned</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'term_loan')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of Working Capital Sanctioned</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'working_capital')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Own Contribution (Margin Money)</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'own_contribution')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Date of Disbursement of 1st Installment</th>
                    <td colspan="2" class="text-right">{{ $application->getData('loan', 'disbursement_date') }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of Disbursement of 1st Installment of Term Loan<br /><small>(Minimum of 30% of Term Loan)</small></th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'disbursed_amount')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Amount of CGTMSE Fee (if any)</th>
                    <td colspan="2" class="text-right">{{ $pageVars['formatter']->format($application->getData('loan', 'cgtmse')) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Transient Account No. of Bank for Disbursement of Subsidy</th>
                    <td colspan="2" class="text-right">{{ $application->getData('loan', 'account_number') }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">IFS Code of the Bank Branch</th>
                    <td colspan="2" class="text-right">{{ $application->bankBranch->getIfsc() }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Bank Name</th>
                    <td colspan="2" class="text-right">{{ $application->bankBranch->bank->name }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">Branch</th>
                    <td colspan="2" class="text-right">{{ $application->bankBranch->name }}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
