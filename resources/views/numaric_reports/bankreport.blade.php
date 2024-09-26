@extends('layouts.admin')

@section('content')
<div class="row align-items-center master_report">
    <h3>Master Report</h3>
    <div class="col-md-12">
        <x-cards.card>
            <div class="header-custom">
                <x-cards.header class="px-md-4 py-md-3 ">
                    <div class="row">
                        <x-filters.reports_filter :statusId="$statusId" :constituencies="$constituencies" :districts="$districts" :tehsils="$tehsils" :blocks="$blocks" :panchayatWards="$panchayatWards" :categories="$categories" :activities="$activities" :perPage="$perPage">
                        </x-filters.reports_filter>
                    </div>
                </x-cards.header>
            </div>
            <x-cards.body>
                <div class="col-md-12">
                <div class="table-container card mb-3">
                    <table class="table table-bordered table-hover table-striped table-condensed wrap-table" id="table">
                        <div class="row export-btns">
                            <!-- <a href="{{ route('numaric_reports.exportReports','recieved') }}" style="width: 150px" class="btn btn-success ml-4">Download</a> -->
                            <button id="printButton" style="width: 150px" class="btn btn-primary">Print</button>
                            <button id="backButton" style="width: 150px" class="btn btn-danger" onclick="goBack()">Go Back</button>
                        </div>
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2" class="text-center">District</th>
                                <th scope="col" colspan="4" class="text-center">At DIC (District Industries Center)</th>
                                <th scope="col" rowspan="2" class="text-center">Pending At Bank For Comments</th>
                                <th scope="col" colspan="4" class="text-center">At DLC (District Level Committee)</th>
                                <th scope="col" rowspan="2" class="text-center">Pending At Bank For Loan Disbursment</th>
                                <th scope="col" rowspan="2" class="text-center">Pending At Nodal DIC</th>
                                <th scope="col" colspan="5" class="text-center">At Bank (Nodal Bank)</th>
                                <th scope="col" rowspan="2" class="text-center">Reverted Back By GM</th>
                                <th scope="col" rowspan="2" class="text-center">Bank Wise Details</th>
                                <th scope="col" rowspan="2" class="text-center">District Wise Details</th>
                            </tr>
                            <tr>
                                <th class="text-right">Recieved</th>
                                <!-- <th class="text-right">Returned</th> -->
                                <th class="text-right">Approved</th>
                                <th class="text-right">Rejected</th>
                                <th class="text-right">Pending</th>
                                <th class="text-right">Recieved</th>
                                <th class="text-right">Approved</th>
                                <th class="text-right">Rejected</th>
                                <th class="text-right">Pending</th>
                                <th class="text-right">Recieved</th>
                                <th class="text-right">Sanctioned</th>
                                <th class="text-right">Pending</th>
                                <th class="text-right">Total Amount Of Loan Involved <span style="color: red">(In lakhs)</span></th>
                                <th class="text-right">Total Amount Of Subsidy Involved <span style="color: red">(In lakhs)</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalReceivedByDIC = 0;
                                $totalApprovedByDIC = 0;
                                $totalRejectedByDIC = 0;
                                $totalPendingByDIC = 0;
                                $totalPendingAtBankForComments = 0;
                                $totalForwardedToDLC = 0;
                                $totalApprovedByDLC = 0;
                                $totalRejectedByDLC = 0;
                                $totalPendingByDLC = 0;
                                $totalPendingAtBankDisbursmentCount = 0;
                                $totalPendingAtNodalDICCount = 0;
                                $totalReceivedToNodalCount = 0;
                                $totalSanctionedByNodalCount = 0;
                                $totalPendingAtNodalCount = 0;
                                $totalAmountOfLoanInvolved = 0;
                                $totalAmountOfSubsidyInvolved = 0;
                                $totalApplicationRevertedBackByGMCount = 0;
                            @endphp

                            @foreach ($reportData as $index => $district)
                                @if (isset($district['Year']) && array_key_exists('DistrictId', $district))
                                    @foreach ($district['Year'] as $yearData)
                                        <tr>
                                            <td class="text-center">{{ $district['District'] }}</td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=305&kind=inc">
                                                    {{ $yearData['Received By DIC'] }}
                                                </a>   
                                            </td>
                                            <!-- <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id[]=307,310&kind=arr">
                                                    {{ $yearData['Returned By DIC'] }}
                                                </a>   
                                            </td> -->
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=307&kind=inc">
                                                    {{ $yearData['Approved By DIC'] }}
                                                </a>    
                                            </td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=307">
                                                    {{ $yearData['Rejected By DIC'] }}
                                                </a>    
                                            </td>
                                            <td class="text-center">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&&status_id=306">
                                                    {{ $yearData['Pending By DIC'] }}
                                                </a>  
                                            </td>
                                            <td class="text-center">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&&status_id=308">
                                                    {{ $yearData['Pending At Bank For Comments'] }}
                                                </a>  
                                            </td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=308&kind=inc">
                                                    {{ $yearData['Forwarded To DLC'] }}
                                                </a>   
                                            </td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=310&kind=inc">
                                                    {{ $yearData['Approved By DLC'] }}
                                                </a>    
                                            </td>
                                            <td class="text-right">
                                                <a target="_blank" href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=310">
                                                    {{ $yearData['Rejected By DLC'] }}
                                                </a>  
                                            </td>
                                            <td class="text-center">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=309">
                                                    {{ $yearData['Pending By DLC'] }}
                                                </a>  
                                            </td>
                                            <td class="text-center">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=311">
                                                    {{ $yearData['Pending At Bank Disbursment Count'] }}
                                                </a>  
                                            </td>
                                            <td class="text-center">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id[]=313,322&kind=arr">
                                                    {{ $yearData['Pending At Nodal DIC Count'] }}
                                                </a>  
                                            </td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id[]=313,322&kind=arr_not">
                                                    {{ $yearData['Received To Nodal Count'] }}
                                                </a>   
                                            </td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id[]=315,317&kind=arr">
                                                    {{ $yearData['Sanctioned By Nodal Count'] }}
                                                </a>    
                                            </td>
                                            <td class="text-right">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id[]=314,316&kind=arr">
                                                    {{ $yearData['Pending At Nodal Count'] }}
                                                </a>    
                                            </td>
                                            @php
                                                $formatter = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);
                                                $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);
                                                $loanAmountInLakhs = $yearData['Total Amount Of Loan Involved'] / 100000;
                                                $subsidyAmountInLakhs = $yearData['Total Amount Of Subsidy Involved'] / 100000;

                                                $totalReceivedByDIC += $yearData['Received By DIC'];
                                                $totalApprovedByDIC += $yearData['Approved By DIC'];
                                                $totalRejectedByDIC += $yearData['Rejected By DIC'];
                                                $totalPendingByDIC += $yearData['Pending By DIC'];
                                                $totalPendingAtBankForComments += $yearData['Pending At Bank For Comments'];
                                                $totalForwardedToDLC += $yearData['Forwarded To DLC'];
                                                $totalApprovedByDLC += $yearData['Approved By DLC'];
                                                $totalRejectedByDLC += $yearData['Rejected By DLC'];
                                                $totalPendingByDLC += $yearData['Pending By DLC'];
                                                $totalPendingAtBankDisbursmentCount += $yearData['Pending At Bank Disbursment Count'];
                                                $totalPendingAtNodalDICCount += $yearData['Pending At Nodal DIC Count'];
                                                $totalReceivedToNodalCount += $yearData['Received To Nodal Count'];
                                                $totalSanctionedByNodalCount += $yearData['Sanctioned By Nodal Count'];
                                                $totalPendingAtNodalCount += $yearData['Pending At Nodal Count'];
                                                $totalAmountOfLoanInvolved += $yearData['Total Amount Of Loan Involved'];
                                                $totalAmountOfSubsidyInvolved += $yearData['Total Amount Of Subsidy Involved'];
                                                $totalApplicationRevertedBackByGMCount += $yearData['Application Reverted Back By GM Count'];
                                            @endphp
                                            <td class="text-right">{{ $formatter->format($loanAmountInLakhs) }}</td>
                                            <td class="text-right">{{ $formatter->format($subsidyAmountInLakhs) }}</td>
                                            <td class="text-center">
                                                <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=321">
                                                    {{ $yearData['Application Reverted Back By GM Count'] }}
                                                </a>        
                                            </td>
                                            <td class="text-center">
                                                <a href="/report/banks">View</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" onclick="handleClick({{ $district['DistrictId'] }}); return false;">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach

                            <!-- Totals Row -->
                            <tr>
                                <td class="text-center"><strong>Totals</strong></td>
                                <td class="text-right"><strong>{{ $totalReceivedByDIC }}</strong></td>
                                <td class="text-right"><strong>{{ $totalApprovedByDIC }}</strong></td>
                                <td class="text-right"><strong>{{ $totalRejectedByDIC }}</strong></td>
                                <td class="text-center"><strong>{{ $totalPendingByDIC }}</strong></td>
                                <td class="text-center"><strong>{{ $totalPendingAtBankForComments }}</strong></td>
                                <td class="text-right"><strong>{{ $totalForwardedToDLC }}</strong></td>
                                <td class="text-right"><strong>{{ $totalApprovedByDLC }}</strong></td>
                                <td class="text-right"><strong>{{ $totalRejectedByDLC }}</strong></td>
                                <td class="text-center"><strong>{{ $totalPendingByDLC }}</strong></td>
                                <td class="text-center"><strong>{{ $totalPendingAtBankDisbursmentCount }}</strong></td>
                                <td class="text-center"><strong>{{ $totalPendingAtNodalDICCount }}</strong></td>
                                <td class="text-right"><strong>{{ $totalReceivedToNodalCount }}</strong></td>
                                <td class="text-right"><strong>{{ $totalSanctionedByNodalCount }}</strong></td>
                                <td class="text-right"><strong>{{ $totalPendingAtNodalCount }}</strong></td>
                                <td class="text-right"><strong>{{ $formatter->format($totalAmountOfLoanInvolved / 100000) }}</strong></td>
                                <td class="text-right"><strong>{{ $formatter->format($totalAmountOfSubsidyInvolved / 100000) }}</strong></td>
                                <td class="text-center"><strong>{{ $totalApplicationRevertedBackByGMCount }}</strong></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                    </div>
                </div>
            </x-cards.body>
            <x-cards.footer>
                {{-- {!! $applications->links() !!} --}}
            </x-cards.footer>
        </x-cards.card>
    </div>
</div>
@endsection
<style>
    .export-btns a,
    .export-btns button {
        margin-left: 15px;
    }
    table a{
        color: blue !important;
    }
    .export-btns {
        display: flex;
    }
    .wrap-table td, .wrap-table th {
        white-space: normal !important;
        word-wrap: break-word !important;
        font-size: 0.9em; 
        max-width: 100px; 
        overflow: hidden; 
    }
    @media print {

        .header-custom,
        body .navbar,
        body .export-btns {
            display: none;
        }
    }

    .sidenav,
    .navbar {
        display: none !important;
    }

    @media (min-width: 1200px) {
        .sidenav.fixed-start+.main-content {
            margin-left: 0 !important;
        }
    }

    .table-container {
        max-width: 100%;
        /* Adjust this as needed */
        overflow-x: auto;
        overflow-y: hidden;
        margin-bottom: 20px;
        /* Optional: Add some space below the table */
    }

    .table-container::-webkit-scrollbar {
        height: 12px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 4px;
    }
    @media print {
        /* Adjust table layout for print */
        table {
            width: 100%;
            table-layout: fixed;
            font-size: 12px;

        }
        .card-body, .card-header, .py-4 {
            padding: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        /* Adjust table cell layout for print */
        td, th {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }
        .table thead th, .table>:not(caption)>*>*{
            padding: 0 !important;
        }
    }
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js" defer="defer"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
     function handleClick(districtId, year) {
        var url = new URL(window.location.href);
        url.searchParams.set('district_id[]', districtId);
        window.location.href = url.toString();
    }
    window.onload = function() {
        if (window.history.length <= 2) {
            document.getElementById('backButton').style.display = 'none';
        }
    }

    function goBack() {
        window.history.back();
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('printButton').addEventListener('click', function() {
            window.print(); // Trigger the browser's print dialog
        });
    });
</script>
