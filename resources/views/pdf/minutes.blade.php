@extends('pdf.base')

@section('title', $title ?? __("Meeting Agenda"))

@section('style')
    <style type="text/css">
        @page { margin: 5px; }
        body { margin: 0px; }
        *{font-size: 10px;}
        th, td{padding: 0;}
        .badge{padding: 3px 2px;border-radius: 3%;display: inline-block;}
    </style>
@endsection

@section('content')
    @php($counter = ['approved' => 0, 'rejected' => 0, 'deferred' => 0])
    @php($formatter = new NumberFormatter('en-IN', NumberFormatter::DECIMAL))
    @php($formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2))
    <table class="w100">
        <caption><strong>{{ $meeting->district->name }}</strong></caption>
        <tr>
            <th scope="col">No. <u>{{ $meeting->unique_id }}</u></th>
            <th scope="col" class="text-right">Time: <u>{{ $meeting->datetime }}</u></th>
        </tr>
    </table>
    <table class="w100 bordered">
        <caption class="text-center"><strong>MEETING MINUTES FOR THE DISTRICT LEVEL COMMITTEE (DLC) UNDER MMSY</strong></caption>
        <thead>
            <tr>
                <th scope="col" rowspan="4">#</th>
                <th scope="col" rowspan="4">ID</th>
                <th scope="col" rowspan="4">Enterprise</th>
                <th scope="col" rowspan="4">Activity</th>
                <th scope="col" rowspan="4">Applicant</th>
                <th scope="col" rowspan="4">Category</th>
                <th scope="col" class="text-center" colspan="5">Investment</th>
                <th scope="col" rowspan="3">Own Contribution</th>
                <th scope="col" rowspan="3">Term Loan</th>
                <th scope="col" rowspan="3">Working Capital</th>
                <th scope="col" rowspan="3">Project Cost</th>
                <th scope="col" rowspan="3">Subsidy <small>(Estimated)</small></th>
                <th scope="col" rowspan="4">Bank</th>
                <th scope="col" rowspan="4">Status</th>
            </tr>
            <tr>
                <th scope="col" rowspan="2">Land</th>
                <th scope="col" class="text-center" colspan="2">Building</th>
                <th scope="col" rowspan="2">Machinery</th>
                <th scope="col" rowspan="2">Working Capital</th>
            </tr>
            <tr>
                <th scope="col">Construction</th>
                <th scope="col">Furniture, Fixtures &amp; Other Fixed Assets</th>
            </tr>
            <tr>
                <th scope="col" colspan="10" class="text-center">(The amount is in Rs. Lakh)</th>
            </tr>
        </thead>
        <tbody>
            @php($totals = ['land_cost' => 0, 'building_cost' => 0, 'assets_cost' => 0, 'machinery_cost' => 0, 'working_capital' => 0, 'own_contribution_amount' => 0, 'term_loan' => 0, 'finance_working_capital' => 0, 'project_cost' => 0, 'subsidy' => 0])
            @foreach($applications as $application)
                <tr>
                    <th scope="row">{{ $loop->iteration }}.</th>
                    <td>{{ $application->unique_id }}</td>
                    <td>M/s {{ $application->getData('enterprise', 'name') }}<br />{{ $application->address }}</td>
                    <td>{{ $application->activity_type->value }} - {{ $application->activity }}</td>
                    <td>
                        {{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }} {{ $application->getData('owner', 'name') }}
                        <br />
                        {{ $application->getData('owner', 'mobile')}}
                        @if($application->getData('owner', 'email'))
                            <br />
                            {{ $application->getData('owner', 'email')}}
                        @endif
                    </td>

                    <td>
                        @php($categoryShown = false)
                        @foreach($application->getCategories() as $category => $info)
                            @if($info['eligible'] > 0)
                                @php($categoryShown = true)
                                <span class="badge">{{ $application->isAFirm() ? round(($info['eligible'] / $info['total']) * 100) . '% ' : '' }}{{ $category }}</span>
                            @endif
                        @endforeach
                        @if(!$categoryShown)
                            <span class="badge">General</span>
                        @endif
                    </td>

                    <td class="text-right">{{ $formatter->format($application->getData('cost', 'land_cost', null, 0) / 100000) }}</td>
                    @php($totals['land_cost'] += $application->getData('cost', 'land_cost'))

                    <td class="text-right">{{ $formatter->format($application->getData('cost', 'building_cost') / 100000) }}</td>
                    @php($totals['building_cost'] += $application->getData('cost', 'building_cost'))

                    <td class="text-right">{{ $formatter->format($application->getData('cost', 'assets_cost') / 100000) }}</td>
                    @php($totals['assets_cost'] += $application->getData('cost', 'assets_cost'))

                    <td class="text-right">{{ $formatter->format($application->getData('cost', 'machinery_cost') / 100000) }}</td>
                    @php($totals['machinery_cost'] += $application->getData('cost', 'machinery_cost'))

                    <td class="text-right">{{ $formatter->format($application->getData('cost', 'working_capital') / 100000) }}</td>
                    @php($totals['working_capital'] += $application->getData('cost', 'working_capital'))

                    <td class="text-right">{{ $formatter->format($application->own_contribution_amount / 100000) }}</td>
                    @php($totals['own_contribution_amount'] += $application->own_contribution_amount)

                    <td class="text-right">{{ $formatter->format($application->term_loan / 100000) }}</td>
                    @php($totals['term_loan'] += $application->term_loan)

                    <td class="text-right">{{ $formatter->format($application->finance_working_capital / 100000) }}</td>
                    @php($totals['finance_working_capital'] += $application->finance_working_capital)

                    <td class="text-right">{{ $formatter->format($application->project_cost / 100000) }}</td>
                    @php($totals['project_cost'] += $application->project_cost)

                    <td class="text-right">{{ $formatter->format($application->subsidy_amount / 100000) }}</td>
                    @php($totals['subsidy'] += $application->subsidy_amount)

                    <td>{{ $application->bank_branch_details }}</td>
                    <td>
                        @php($meetingApplication = $application->meetingApplications->first())
                        @if($meetingApplication->status == 'APPROVED')
                            @php($counter['approved']++)
                        @elseif($meetingApplication->status == 'REJECTED')
                            @php($counter['rejected']++)
                        @elseif($meetingApplication->status == 'DEFERRED')
                            @php($counter['deferred']++)
                        @endif
                        <strong>{{ $meetingApplication->status }}</strong><hr />
                        <small>{{ $meetingApplication->remarks }}</small>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th scope="row" colspan="6" rowspan="2" class="text-center">Total</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['land_cost'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['building_cost'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['assets_cost'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['machinery_cost'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['working_capital'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['own_contribution_amount'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['term_loan'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['finance_working_capital'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['project_cost'] / 100000) }}</th>
                <th scope="col" class="text-right">{{ $formatter->format($totals['subsidy'] / 100000) }}</th>
                <th scope="col" rowspan="2" colspan="2"></th>
            </tr>
            <tr>
                <th scope="col" colspan="10" class="text-center">(The amount is in Rs. Lakh)</th>
            </tr>
            <tr><td colspan="18">&nbsp;</td></tr>
            <tr>
                <th scope="row" colspan="4">Total Cases</th>
                <td colspan="2" class="text-right">{{ $counter['approved'] + $counter['rejected'] + $counter['deferred'] }} &nbsp;</td>
                <th scope="row" colspan="2">Approved Cases</th>
                <td colspan="2" class="text-right">{{ $counter['approved'] }} &nbsp;</td>
                <th scope="row" colspan="2">Rejected Cases</th>
                <td colspan="2" class="text-right">{{ $counter['rejected'] }} &nbsp;</td>
                <th scope="row" colspan="2">Deferred Cases</th>
                <td colspan="2" class="text-right">{{ $counter['deferred'] }} &nbsp;</td>
            </tr>
        </tfoot>
    </table>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>
    <p class="text-right"><strong><u>Signature</u></strong></p>
@endsection