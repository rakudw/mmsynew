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
                
                </tr>
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">Applicant</th>
                    <th scope="col">Status</th>
                    <th scope="col">Owner District</th>
                    <th scope="col">Bank name</th>
                    <th scope="col">Branch name</th>
                    <th scope="col" class="text-end">Submitted On</th>
                    <th scope="col" class="text-end">Activity</th>
                    <th scope="col" class="text-end">Investment</th>
                    <th scope="col" class="text-end">Loan Amount</th>
                </tr>
            </thead>
            <tbody>
                @php($counter = 1)
                @php($grandTotal = ['investment' => 0, 'loan' => 0])
                @foreach ($data as $status => $applications)
                
                    @if(count($applications) > 0)
                        <tr>
                            <th scope="col" class="text-center" colspan="2">
                                {{ ucfirst($status) }}
                            </th>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        @php($subTotal = ['investment' => 0, 'loan' => 0])
                        @foreach($applications as $application)
                        
                            @php($subTotal['investment'] += $application->own_contribution_amount)
                            @php($subTotal['loan'] += $application->term_loan)
                            <tr>
                                <td class="text-end align-middle">{{ $counter++ }}.)</td>
                                <td class="align-middle">
                                    M/s {{ $application->name }}<br />
                                    <address>{{ $application->address }}</address><hr />
                                    {{ $application->applicant }}<br />
                                    <address>{{ $application->applicant_address }}</address>
                                </td>
                                <td class="text-end">{{ $application->status}}</td>
                                <td class="text-end">{{ $application->owner_district}}</td>
                                <td class="text-end">{{ $application->bank}}</td>
                                 <td class="text-end">{{ $application->bank_branch }}</td> <td class="text-end">{{ $application->applicationTimelines->first()->created_at }}</td>
                                <td class="text-end">
                                    <strong>[{{ $application->activity_type }}]: {{ $application->activity }}</strong><br />
                                    {{ $application->activity_detail }}
                                    @if(isset($rejections[$application->id]))
                                        <hr />
                                        <code>
                                            {{ ucfirst($rejections[$application->id]->remarks) }}<br />at {{ $rejections[$application->id]->created_at }}
                                        </code>
                                    @endif
                                </td>
                                <td class="text-end">
                                    {{ $formatter->format($application->own_contribution_amount) }}
                                </td>
                                <td class="text-end">
                                    {{ $formatter->format($application->term_loan) }}
                                </td>
                            </tr>
                        @endforeach

                        @php($grandTotal['investment'] += $subTotal['investment'])
                        @php($grandTotal['loan'] += $subTotal['loan'])

                        @if (count($applications) > 1)
                            <tr>
                                <th scope="row" colspan="4" class="text-center">Total</th>
                                <td class="text-end">{{ $formatter->format($subTotal['investment']) }}</td>
                                <td class="text-end">{{ $formatter->format($subTotal['loan']) }}</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr>
                    <th scope="row" colspan="4" class="text-center">Grand Total</th>
                    <td class="text-end">{{ $formatter->format($grandTotal['investment']) }}</td>
                    <td class="text-end">{{ $formatter->format($grandTotal['loan']) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script type="module">
        document.querySelectorAll('.table td, .table th').forEach(e => e.style.whiteSpace = 'inherit');
    </script>
@endsection
