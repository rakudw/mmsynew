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
                </button>
            </div>
            <form class="form-inline text-end">
                <input type="text" placeholder="start date" value="{{ $parameters['period']['start'] }}" name="start" class="mb-1 form-control" title="Start Date" />
                <input type="text" placeholder="end date" value="{{ $parameters['period']['end'] }}" name="end" class=" mb-1 form-control" title="End Date" />
                <select name="district" class="mb-1 form-control" title="District">
                    @if(count($parameters['districts']) > 1)
                        <option value="">All Districts</option>
                    @endif
                    @foreach($parameters['districts'] as $id => $name)
                        <option value="{{ $id }}" @selected($id == $parameters['district'])>{{ $name}}</option>
                    @endforeach
                </select>
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
                        Banks Overview<br />
                        <small>({{ $parameters['period']['start'] }} to {{ $parameters['period']['end'] }})</small>
                    </th>
                </tr>
                <tr>
                    <th rowspan="3" scope="col">Sr. No.</th>
                    <th rowspan="3" scope="col">Bank</th>
                    <th scope="col" colspan="2" class="text-center">Sponsored</th>
                    <th scope="col" colspan="2" class="text-center">Sanctioned</th>
                    <th scope="col" colspan="2" class="text-center">Pending</th>
                    <th scope="col" colspan="2" class="text-center">Rejected</th>
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
                @foreach ($banks as $bankType => $bankList)
                    <tr>
                        <th scope="col" class="text-center" colspan="2">
                            {{ str_replace('_', ' ', \App\Enums\BankTypeEnum::fromId($bankType)->name) }}S</th>
                        <td colspan="8">&nbsp;</td>
                    </tr>
                    @php($subTotal = ['sponsored' => [0, 0], 'sanctioned' => [0, 0], 'rejected' => [0, 0], 'pending' => [0, 0]])
                    @foreach($bankList as $bank)
                        @php($bankData = isset($data[$bank['id']]) ? $data[$bank['id']] : null)

                        @php($subTotal['sanctioned'][0] += $bankData['sanctioned']['count'])
                        @php($subTotal['rejected'][0] += $bankData['rejected']['count'])
                        @php($subTotal['sponsored'][0] += $bankData['sponsored']['count'])
                        @php($subTotal['pending'][0] += $bankData['pending']['count'])

                        @php($subTotal['sanctioned'][1] += $bankData['sanctioned']['capital_expenditure'])
                        @php($subTotal['rejected'][1] += $bankData['rejected']['capital_expenditure'])
                        @php($subTotal['sponsored'][1] += $bankData['sponsored']['capital_expenditure'])
                        @php($subTotal['pending'][1] += $bankData['pending']['capital_expenditure'])

                        <tr>
                            <td class="text-end align-middle">{{ $counter++ }}.)</td>
                            <td class="align-middle">
                                <a href="{{ route('report.bank', ['bank' => $bank['id'], 'start' => $parameters['period']['start'], 'end' => $parameters['period']['end']]) }}">{{ $bank->name }}</a>
                            </td>
                            @if($bankData['sponsored']['count'] > 0)
                                <td class="text-end">{{ $formatter->format($bankData['sponsored']['count']) }}</td>
                                <td class="text-end">{{ $currencyFormatter->format($bankData['sponsored']['capital_expenditure']) }}</td>
                            @else
                                <td colspan="2" class="text-center"><i>-na-</i></td>
                            @endif
                            @if($bankData['sanctioned']['count'] > 0)
                                <td class="text-end">{{ $formatter->format($bankData['sanctioned']['count']) }}</td>
                                <td class="text-end">{{ $currencyFormatter->format($bankData['sanctioned']['capital_expenditure']) }}</td>
                            @else
                                <td colspan="2" class="text-center"><i>-na-</i></td>
                            @endif
                            @if($bankData['pending']['count'] > 0)
                                <td class="text-end">{{ $formatter->format($bankData['pending']['count']) }}</td>
                                <td class="text-end">{{ $currencyFormatter->format($bankData['pending']['capital_expenditure']) }}</td>
                            @else
                                <td colspan="2" class="text-center"><i>-na-</i></td>
                            @endif
                            @if($bankData['rejected']['count'] > 0)
                                <td class="text-end">{{ $formatter->format($bankData['rejected']['count']) }}</td>
                                <td class="text-end">{{ $currencyFormatter->format($bankData['rejected']['capital_expenditure']) }}</td>
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

                    @if ($bankList->count() > 1)
                        <tr>
                            <th scope="row" colspan="2" class="text-center">Total</th>
                            <td class="text-end">{{ $formatter->format($subTotal['sponsored'][0]) }}</td>
                            <td class="text-end">{{ $currencyFormatter->format($subTotal['sponsored'][1]) }}</td>
                            <td class="text-end">{{ $formatter->format($subTotal['sanctioned'][0]) }}</td>
                            <td class="text-end">{{ $currencyFormatter->format($subTotal['sanctioned'][1]) }}</td>
                            <td class="text-end">{{ $formatter->format($subTotal['pending'][0]) }}</td>
                            <td class="text-end">{{ $currencyFormatter->format($subTotal['pending'][1]) }}</td>
                            <td class="text-end">{{ $formatter->format($subTotal['rejected'][0]) }}</td>
                            <td class="text-end">{{ $currencyFormatter->format($subTotal['rejected'][1]) }}</td>
                        </tr>
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
