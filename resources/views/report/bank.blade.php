@extends('layouts.admin')

@section('title', $pageVars['title'] ?? 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                {{ $pageVars['title'] ?? __('Banks Overview') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    @php($formatter = new NumberFormatter('en-IN', NumberFormatter::DECIMAL))
    @php($formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2))

    @php($currencyFormatter = new NumberFormatter('en-IN', NumberFormatter::CURRENCY))
    @php($currencyFormatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2))

    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="align-bottom">
                <button type="button" data-export="report" data-export-name="Bank Overview" class="btn btn-secondary">
                    <em class="fas fa-file"></em>
                    Export
                </button><br />
                <button type="button" data-print="#report" data-export-name="Bank Overview" class="btn btn-info">
                    <em class="fas fa-print"></em>
                    Print
                </button><br />
                <a href="{{ route('report.banks', ['start' => $parameters['period']['start'], 'end' => $parameters['period']['end']]) }}" data-print="#report" data-export-name="Bank Overview" class="btn btn-warning text-dark">
                    <em class="fas fa-backward"></em>
                    Back
                </a>
            </div>
            <form class="form-inline text-end">
                <input type="text" placeholder="start date" value="{{ $parameters['period']['start'] }}" name="start" class="mb-1 form-control" title="Start Date" />
                <input type="text" placeholder="end date" value="{{ $parameters['period']['end'] }}" name="end" class=" mb-1 form-control" title="End Date" />
                <input type="submit" class="btn btn-sm btn-primary" value="Show" />
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped" id="report">
            <caption></caption>
            <thead>
                <tr>
                    <th scope="col" class="text-center" colspan="10">
                        {{ $bank->name }} - {{ $bank->type->name }}<br />
                        <small>({{ $parameters['period']['start'] }} to {{ $parameters['period']['end'] }})</small>
                    </th>
                </tr>
                <tr>
                    <th scope="col" rowspan="3">Sr. No.</th>
                    <th scope="col" rowspan="3">Branch</th>
                    <th scope="col" class="text-end" colspan="2">Sponsored</th>
                    <th scope="col" class="text-end" colspan="2">Sanctioned</th>
                    <th scope="col" class="text-end" colspan="2">Pending</th>
                    <th scope="col" class="text-end" colspan="2">Rejected</th>
                </tr>
                <tr>
                    <th scope="col" class="text-end">Count</th>
                    <th scope="col" class="text-end">Amount</th>
                    <th scope="col" class="text-end">Count</th>
                    <th scope="col" class="text-end">Amount</th>
                    <th scope="col" class="text-end">Count</th>
                    <th scope="col" class="text-end">Amount</th>
                    <th scope="col" class="text-end">Count</th>
                    <th scope="col" class="text-end">Amount</th>
                </tr>
                <tr>
                    <th scope="col" colspan="8" class="text-center">
                        <small>(The amount is in Rs. Lakhs.)</small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php($counter = 1)
                @php($grandTotal = ['sponsored' => [0, 0], 'sanctioned' => [0, 0], 'rejected' => [0, 0], 'pending' => [0, 0]])
                @foreach ($parameters['districts'] as $districtId => $districtName)
                    @if(isset($data[$districtId]))
                        <tr>
                            <th scope="col" class="text-center" colspan="2">
                                {{ $districtName }}</th>
                            <td colspan="8">&nbsp;</td>
                        </tr>
                        @php($subTotal = ['sponsored' => [0, 0], 'sanctioned' => [0, 0], 'rejected' => [0, 0], 'pending' => [0, 0]])
                        @foreach($data[$districtId] as $branchId => $branchData)

                            @php($subTotal['sanctioned'][0] += $branchData['sanctioned']['count'])
                            @php($subTotal['rejected'][0] += $branchData['rejected']['count'])
                            @php($subTotal['sponsored'][0] += $branchData['sponsored']['count'])
                            @php($subTotal['pending'][0] += $branchData['pending']['count'])

                            @php($subTotal['sanctioned'][1] += $branchData['sanctioned']['capital_expenditure'])
                            @php($subTotal['rejected'][1] += $branchData['rejected']['capital_expenditure'])
                            @php($subTotal['sponsored'][1] += $branchData['sponsored']['capital_expenditure'])
                            @php($subTotal['pending'][1] += $branchData['pending']['capital_expenditure'])

                            <tr>
                                <td class="text-end align-middle">{{ $counter++ }}.)</td>
                                <td class="align-middle">
                                    <a href="{{ route('report.bank_branch', ['bankBranch' => $branchId, 'start' => $parameters['period']['start'], 'end' => $parameters['period']['end']]) }}">{{ $branchData['title'] }}</a>
                                </td>
                                @if($branchData['sponsored']['count'] > 0)
                                    <td class="text-end">{{ $formatter->format($branchData['sponsored']['count']) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($branchData['sponsored']['capital_expenditure']) }}</td>
                                @else
                                    <td colspan="2" class="text-center"><i>-na-</i></td>
                                @endif
                                @if($branchData['sanctioned']['count'] > 0)
                                    <td class="text-end">{{ $formatter->format($branchData['sanctioned']['count']) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($branchData['sanctioned']['capital_expenditure']) }}</td>
                                @else
                                    <td colspan="2" class="text-center"><i>-na-</i></td>
                                @endif
                                @if($branchData['pending']['count'] > 0)
                                    <td class="text-end">{{ $formatter->format($branchData['pending']['count']) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($branchData['pending']['capital_expenditure']) }}</td>
                                @else
                                    <td colspan="2" class="text-center"><i>-na-</i></td>
                                @endif
                                @if($branchData['rejected']['count'] > 0)
                                    <td class="text-end">{{ $formatter->format($branchData['rejected']['count']) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($branchData['rejected']['capital_expenditure']) }}</td>
                                @else
                                    <td colspan="2" class="text-center"><i>-na-</i></td>
                                @endif
                            </tr>
                        @endforeach

                        @php($grandTotal['sanctioned'][0] += $subTotal['sanctioned'][0])
                        @php($grandTotal['rejected'][0] += $subTotal['rejected'][0])
                        @php($grandTotal['sponsored'][0] += $subTotal['sponsored'][0])
                        @php($grandTotal['pending'][0] += $subTotal['pending'][0])

                        @php($grandTotal['sanctioned'][1] += $subTotal['sanctioned'][1])
                        @php($grandTotal['rejected'][1] += $subTotal['rejected'][1])
                        @php($grandTotal['sponsored'][1] += $subTotal['sponsored'][1])
                        @php($grandTotal['pending'][1] += $subTotal['pending'][1])

                        @if (count($data[$districtId]) > 1)
                            <tr>
                                <th scope="row" colspan="2" class="text-center">Total</th>
                                @if($subTotal['sponsored'][0] > 0)
                                    <td class="text-end">{{ $formatter->format($subTotal['sponsored'][0]) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($subTotal['sponsored'][1]) }}</td>
                                @else
                                    <th scope="col" colspan="2" class="text-center"><i>-na-</i></th>
                                @endif
                                @if($subTotal['sanctioned'][0] > 0)
                                    <td class="text-end">{{ $formatter->format($subTotal['sanctioned'][0]) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($subTotal['sanctioned'][1]) }}</td>
                                @else
                                    <th scope="col" colspan="2" class="text-center"><i>-na-</i></th>
                                @endif
                                @if($subTotal['pending'][0] > 0)
                                    <td class="text-end">{{ $formatter->format($subTotal['pending'][0]) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($subTotal['pending'][1]) }}</td>
                                @else
                                    <th scope="col" colspan="2" class="text-center"><i>-na-</i></th>
                                @endif
                                @if($subTotal['rejected'][0] > 0)
                                    <td class="text-end">{{ $formatter->format($subTotal['rejected'][0]) }}</td>
                                    <td class="text-end">{{ $currencyFormatter->format($subTotal['rejected'][1]) }}</td>
                                @else
                                    <th scope="col" colspan="2" class="text-center"><i>-na-</i></th>
                                @endif
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr>
                    <th scope="row" colspan="2" rowspan="2" class="text-center">Grand Total</th>
                    <td class="text-end">{{ $formatter->format($grandTotal['sponsored'][0]) }}</td>
                    <td class="text-end">{{ $currencyFormatter->format($grandTotal['sponsored'][1]) }}</td>
                    <td class="text-end">{{ $formatter->format($grandTotal['sanctioned'][0]) }}</td>
                    <td class="text-end">{{ $currencyFormatter->format($grandTotal['sanctioned'][1]) }}</td>
                    <td class="text-end">{{ $formatter->format($grandTotal['pending'][0]) }}</td>
                    <td class="text-end">{{ $currencyFormatter->format($grandTotal['pending'][1]) }}</td>
                    <td class="text-end">{{ $formatter->format($grandTotal['rejected'][0]) }}</td>
                    <td class="text-end">{{ $currencyFormatter->format($grandTotal['rejected'][1]) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
