<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <title>Annexure-A : Approval letter under Mukhya Mantri Swavlamban Yojna</title>
        <style type="text/css">
            *{font-family: DejaVu Sans, sans-serif !important;font-size: 12px;}
            h3{font-size: large;}
            small{font-size: small;}
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
        @php($meeting = $application->approval_meeting)
        <p class="text-right"><strong>Annexure-A</strong></p>
        <p class="text-center"><strong>Approval Letter under Mukhya Mantri Swavlamban Yojna</strong></p>
        <table class="w100">
            <tr>
                <td><strong>Registration ID: <u>{{ $application->unique_id }}</u></strong></td>
                <td class="text-right"><strong>Registration Date: <u>{{ $application->submitted_at }}</u></strong></td>
            </tr>
        </table>
        <p class="text-justify">The District Level Committee (DLC) constitued under the Mukhya Mantri Swavlamban Yojna, 2019 vide No. Ind-A(F)2-1/2018/Loose dated 23rd February, 2019 of District <u>{{ $application->region->name }}</u> in its <u>{{ $meeting ? $meeting->title : '' }}</u> meeting held on <u>{{ $meeting ? $meeting->datetime : 'NA' }}</u> has approved in principle the project proposal of Sh./M/s <u>{{ $application->name }}</u> address <u>{{ $application->address }}</u> phone/mobile number <u>{{ $application->mobile }}</u> for the setting up of <u>{{ $application->activity }}</u> ({{ $application->activity_type->value }}). The DLC approved parameters of the project are as under:</p>
        <table class="w100 bordered">
            <caption></caption>
            <thead>
                <tr>
                    <th scope="col">Details of Project Cost</th>
                    <th scope="col">Amount (Rs.)</th>
                    <th scope="col" colspan="2">Means of Finance</th>
                    <th scope="col">Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="5" scope="col">A) Capital Expenditure</th>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;(i) Land</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'land_cost')) }}</td>
                    <th rowspan="4" colspan="2" scope="row">Own Contribution (min @10%)</th>
                    <td rowspan="4" class="text-right">{{ $pageVars['formatter']->format($application->own_contribution_amount) }}</td>
                </tr>
                <tr>
                    <th colspan="2" scope="col">&nbsp;&nbsp;(ii) Building</th>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;a) Construction/Rennovation</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'building_cost')) }}</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;b) Furniture/Fixtures/Other Fixed Cost</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'assets_cost')) }}</td>
                </tr>
                <tr>
                    <th scope="col">&nbsp;&nbsp;(iii) Macninery/Equipment</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'machinery_cost')) }}</td>
                    <th scope="row" rowspan="2" style="width: 3%">L<br />O<br />A<br />N</th>
                    <th scope="col">Term Loan</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->term_loan) }}</td>
                </tr>
                <tr>
                    <th scope="col">B) Working Capital</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->getData('cost', 'working_capital')) }}</td>
                    <th scope="col">Cash Credit Limit</th>
                    <td class="text-right">{{ $pageVars['formatter']->format($application->finance_working_capital) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" scope="row">Total</th>
                    <th class="text-right" scope="row">{{ $pageVars['formatter']->format($application->project_cost) }}</th>
                    <th class="text-center" colspan="2" scope="row">Total</th>
                    <th class="text-right" scope="row">{{ $pageVars['formatter']->format($application->project_cost) }}</th>
                </tr>
                <tr>
                    <th scope="row" colspan="2" class="text-center">Estimated Subsidy Involved</th>
                    <th scope="row" colspan="3" class="text-right">{{ $pageVars['formatter']->format($application->subsidy_amount) }}</th>
                </tr>
				<tr>
					<th scope="col" colspan="5" class="text-center">{{ $application->bank_branch_details }}</th>
				</tr>
            </tfoot>
        </table>
        <p class="text-justify">60% of subsidy amount would be disbursed by the nodal bank to the concerned branch which has sanctioned loan in favour of beneficiary. The unit would be eligible for the following:-</p>
        <ol class="text-justify">
            <li>Capital subsidy @(25%/30%/35%), 60% of which will be disbursed at the time of disbursement of 1st installment of loan and 40% would be disbursed after commencement of production/operation.</li>
            <li>Interest Subsidy @@5% for three years on loan upto Rs. 60 lakh sanctioned by a &quot;Financial institution&quot;.</li>
            <li>Reimbursement of CGTSME fee to the bank for repayment period of 5-7 years as decided by the bank.</li>
            <li>The enterprise should commence commercial production/operation within 1 year of disbursement of 1st installment of loan by the bank.</li>
            <li>The unit would also be eligible for grant of incentives as specified under "The Himachal Pradesh Industrial investment policy, 2019" and "Rules Regarding Grant of Incentives, Concessions and Facilities for Investment Promotion in Himachal Pradesh-2019" as amended from time to time, but incentive will not be available for the same component twice.</li>
        </ol>
        <p class="text-justify">
            <strong>Note:</strong> Plant and Machinery (including construction, physical durable assets for service/trade/shop enterprises) for which payment has been made in cash would not be eligible for subsidy.
        </p>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <p class="text-right">
            General Manager,<br />
            District Industries Center,<br />
            {{ $application->region->name }}, Himachal Pradesh
        </p>
    </body>
</html>
