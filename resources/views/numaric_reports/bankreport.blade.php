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
                            <th scope="col" rowspan="2" class="text-center">Sr. No.</th>
                            <th scope="col" rowspan="2" class="text-center">Year</th>
                            <th scope="col" rowspan="2" class="text-center">Name of District</th>
                            <th scope="col" colspan="5" class="text-center">No. of Application at DIC</th>
                            <th scope="col" rowspan="2" class="text-center">No. applications at Bank for Comments</th>
                            <th scope="col" colspan="4" class="text-center">No of Cases at District Level Committee</th>
                            <th scope="col" rowspan="2" class="text-center">No of Cases Forwarded to Bank for Sanction</th>
                            <th scope="col" colspan="6" class="text-center">Sanctioned By Bank</th>


                            <th scope="col" colspan="4" class="text-center">60% Cases (Nodal Bank)</th>
                            <th scope="col" colspan="4" class="text-center">40% Cases (Nodal Bank)</th>

                            <th scope="col" rowspan="2" class="text-center">Bank Wise Details</th>
                            <th scope="col" rowspan="2" class="text-center">District Wise Details</th>
                        </tr>
                        <tr>
                            <th class="text-right">Received</th>
                            <th class="text-right">Returned/Rejected</th>
                            <th class="text-right">Withdrawn</th>
                            <th class="text-right">Applications Pending to be forwarded to Banks for Comments</th>
                            <th class="text-right">Applications Forwarded to Banks for Comments</th>
{{--                            <th class="text-right">Considered Application Revert by Banks </th>--}}

{{--                            <th class="text-right">Applications Pending At Bank For Comments</th>--}}
                            <th class="text-right">Cases Placed In DLC</th>
                            <th class="text-right">Approved By DLC</th>
                            <th class="text-right">Rejected By DLC</th>
                            <th class="text-right">No of Cases Pending At DLC Level to be place in DLC</th>
                            {{-- Bank Section   --}}
                            <th class="text-right">No. of cases Sanctioned by Bank</th>
                            <th class="text-right">Total Amount of Investment Involved <span style="color: red">(In lakhs)</span></th>
                            <th class="text-right">Total Amount Of Loan Involved <span style="color: red">(In lakhs)</span></th>
                            <th class="text-right">Total Amount Of Subsidy Involved <span style="color: red">(In lakhs)</span></th>
                            <th class="text-right">No. of Application rejected by the bank</th>
                            <th class="text-right">No. of cases pending at bank level for sanction</th>
                            {{-- Bank Section  End --}}

                            {{-- 60%  Section   --}}
                            <th class="text-right">Cases Pending at GM DIC For 60% Release</th>
                            <th class="text-right">Cases sent to Nodal bank for release of 60% Capital Subsidy by GM DIC</th>
                            <th class="text-right">60% Capital subsidy released by Nodal Bank</th>
                            <th class="text-right">Cases Pending for 60% Capital subsidy released by Nodal Bank</th>
                            {{-- 60%  Section End  --}}

                            {{-- 40%  Section   --}}
                            <th class="text-right">Cases Pending at GM DIC For 40% Release</th>
                            <th class="text-right">Cases sent to Nodal Bank for release of 40% Capital Subsidy By GM DIC</th>
                            <th class="text-right">40% Capital subsidy   released by Nodal Bank</th>
                            <th class="text-right">Cases Pending for 40% Capital subsidy released by Nodal Bank</th>
                            {{-- 40%  Section End  --}}
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData as $index => $district)
                            @if (isset($district['Year']) && array_key_exists('DistrictId', $district))
                                @foreach ($district['Year'] as $yearData)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td  class="text-center">{{ end($district['Year'])['Year'] }}</td>
                                        <td class="text-center">{{ $district['District'] }}</td>
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=302&kind=inc">
                                                {{ $yearData['Received'] }}
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id[]=305,307&kind=arr">
                                                {{ $yearData['Returned'] }}
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=303">
                                                {{ $yearData['Withdrawn'] }}
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=306">
                                                {{ $yearData['PendingDIC'] }}
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=307&kind=incor">
                                                {{ $yearData['Forwarded To Bank For Comments'] }}
                                            </a>
                                        </td>
                                {{-- Bank For comments Section  --}}

                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=308">
                                                {{ $yearData['Applications Pending At Bank For Comments'] }}
                                            </a>
                                        </td>
                                    {{-- End Bank For comments Section  --}}
                                    {{-- DLC  Section  --}}

                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=308&kind=incor">
                                                {{ $yearData['Forwarded To DLC'] }}
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=310&kind=incor">
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
                                                {{ $yearData['No of Applications Pending ar DLC'] }}
                                            </a>
                                        </td>
                                        {{-- End DLC  Section  --}}
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=310&kind=incor">
                                                {{ $yearData['No of Applications Forwarded to Bank'] }}
                                            </a>
                                        </td>
                                        {{-- Nodal Bank  Section  --}}
                                        <td class="text-right">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=311&kind=inc">
                                                {{ $yearData['No Of Cases'] }}
                                            </a>
                                        </td>
                                        @php
                                            $formatter = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);
                                            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);
                                        @endphp
                                        <td class="text-right">{{ $formatter->format($yearData['Total Amount of Investment Involved'] / 100000) }}</td>
                                        <td class="text-right">{{ $formatter->format($yearData['Total Amount of Loan Involved'] / 100000) }}</td>
                                        <td class="text-right">{{ $formatter->format($yearData['Total Amount of Subsidy Involved'] / 100000) }} </td>
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=304">
                                                {{ $yearData['No Of Application Rejected By The Bank'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=311">
                                                {{ $yearData['No Of Cases Pending at Bank Level'] }}
                                            </a>
                                        </td>
                                        {{-- End Nodal Bank  Section  --}}

                                        {{-- Cases 60% Section--}}
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=313">
                                                {{ $yearData['Cases Pending at GM DIC For 60% Release'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=313&kind=inc">
                                                {{ $yearData['Cases sent to Nodal bank for release of 60% Capital Subsidy by GM DIC'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=314&kind=inc">
                                                {{ $yearData['60% Capital subsidy released by Nodal Bank'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=314">
                                                {{ $yearData['Cases Pending for 60% Capital subsidy released by Nodal Bank'] }}
                                            </a>
                                        </td>


                                        {{-- Cases 40% Section--}}
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=322">
                                                {{ $yearData['Cases Pending at GM DIC For 40% Release'] }}
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=315&kind=inc">
                                                {{ $yearData['Cases sent to Nodal Bank for release of 40% Capital Subsidy By GM DIC'] }}
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=316&kind=inc">
                                                {{ $yearData['40% Capital subsidy released by Nodal Bank'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=316">
                                                {{ $yearData['Cases Pending for 40% Capital subsidy released by Nodal Bank'] }}
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
                        </tbody>
                        <tfoot>
                                <tr>
                                    <td colspan="3" class="text-center"><strong>Totals</strong></td>
                                    <td class="text-right" id="totalReceived"></td>
                                    <td class="text-right" id="totalReturned"></td>
                                    <td class="text-right" id="totalWithdrawn"></td>
                                    <td class="text-right" id="totalPendingDIC"></td>
                                    <td class="text-right" id="totalForwardedToBankForComments"></td>
                                    <td class="text-right" id="totalApplicationsPendingAtBankForComments"></td>
                                    <td class="text-right" id="totalForwardedToDLC"></td>
                                    <td class="text-right" id="totalApprovedByDLC"></td>
                                    <td class="text-right" id="totalRejectedByDLC"></td>
                                    <td class="text-right" id="totalPendingAtDLC"></td>
                                    <td class="text-right" id="totalForwardedToBank"></td>
                                    <td class="text-right" id="totalNoOfCases"></td>
                                    <td class="text-right" id="totalInvestmentInvolved"></td>
                                    <td class="text-right" id="totalLoanInvolved"></td>
                                    <td class="text-right" id="totalSubsidyInvolved"></td>
                                    <td class="text-right" id="totalRejectedByBank"></td>
                                    <td class="text-right" id="totalPendingAtBank"></td>
                                    <td class="text-right" id="totalPendingAtGMDIC60"></td>
                                    <td class="text-right" id="totalSentToNodalBank60"></td>
                                    <td class="text-right" id="totalReleasedByNodalBank60"></td>
                                    <td class="text-right" id="totalPendingForNodalBank60"></td>
                                    <td class="text-right" id="totalPendingAtGMDIC40"></td>
                                    <td class="text-right" id="totalSentToNodalBank40"></td>
                                    <td class="text-right" id="totalReleasedByNodalBank40"></td>
                                    <td class="text-right" id="totalPendingForNodalBank40"></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                    </table>
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
    .row{
        padding-right: 0 !important;
    }
    .container-fluid, .card-body, .table-container{
        padding: 0 !important;
    }
    .table thead th{
        padding: 2px !important;
    }
    .wrap-table td, .wrap-table th{
        font-size: 0.7em !important;
    }
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

$(document).ready(function() {
        setTimeout(() => {
            let totals = {
                Received: 0,
                Returned: 0,
                Withdrawn: 0,
                PendingDIC: 0,
                ForwardedToBankForComments: 0,
                ApplicationsPendingAtBankForComments: 0,
                ForwardedToDLC: 0,
                ApprovedByDLC: 0,
                RejectedByDLC: 0,
                PendingAtDLC: 0,
                ForwardedToBank: 0,
                NoOfCases: 0,
                InvestmentInvolved: 0,
                LoanInvolved: 0,
                SubsidyInvolved: 0,
                RejectedByBank: 0,
                PendingAtBank: 0,
                PendingAtGMDIC60: 0,
                SentToNodalBank60: 0,
                ReleasedByNodalBank60: 0,
                PendingForNodalBank60: 0,
                PendingAtGMDIC40: 0,
                SentToNodalBank40: 0,
                ReleasedByNodalBank40: 0,
                PendingForNodalBank40: 0
            };

            document.querySelectorAll('tbody tr').forEach(row => {
                if (row.children[3]) {
                    totals.Received += parseInt(row.children[3].innerText) || 0;
                }
                if (row.children[4]) {
                    totals.Returned += parseInt(row.children[4].innerText) || 0;
                }
                if (row.children[5]) {
                    totals.Withdrawn += parseInt(row.children[5].innerText) || 0;
                }
                if (row.children[6]) {
                    totals.PendingDIC += parseInt(row.children[6].innerText) || 0;
                }
                if (row.children[7]) {
                    totals.ForwardedToBankForComments += parseInt(row.children[7].innerText) || 0;
                }
                if (row.children[8]) {
                    totals.ApplicationsPendingAtBankForComments += parseInt(row.children[8].innerText) || 0;
                }
                if (row.children[9]) {
                    totals.ForwardedToDLC += parseInt(row.children[9].innerText) || 0;
                }
                if (row.children[10]) {
                    totals.ApprovedByDLC += parseInt(row.children[10].innerText) || 0;
                }
                if (row.children[11]) {
                    totals.RejectedByDLC += parseInt(row.children[11].innerText) || 0;
                }
                if (row.children[12]) {
                    totals.PendingAtDLC += parseInt(row.children[12].innerText) || 0;
                }
                if (row.children[13]) {
                    totals.ForwardedToBank += parseInt(row.children[13].innerText) || 0;
                }
                if (row.children[14]) {
                    totals.NoOfCases += parseInt(row.children[14].innerText) || 0;
                }
                if (row.children[15]) {
                    totals.InvestmentInvolved += parseFloat(row.children[15].innerText.replace(/,/g, '')) || 0;
                }
                if (row.children[16]) {
                    totals.LoanInvolved += parseFloat(row.children[16].innerText.replace(/,/g, '')) || 0;
                }
                if (row.children[17]) {
                    totals.SubsidyInvolved += parseFloat(row.children[17].innerText.replace(/,/g, '')) || 0;
                }
                if (row.children[18]) {
                    totals.RejectedByBank += parseInt(row.children[18].innerText) || 0;
                }
                if (row.children[19]) {
                    totals.PendingAtBank += parseInt(row.children[19].innerText) || 0;
                }
                if (row.children[20]) {
                    totals.PendingAtGMDIC60 += parseInt(row.children[20].innerText) || 0;
                }
                if (row.children[21]) {
                    totals.SentToNodalBank60 += parseInt(row.children[21].innerText) || 0;
                }
                if (row.children[22]) {
                    totals.ReleasedByNodalBank60 += parseInt(row.children[22].innerText) || 0;
                }
                if (row.children[23]) {
                    totals.PendingForNodalBank60 += parseInt(row.children[23].innerText) || 0;
                }
                if (row.children[24]) {
                    totals.PendingAtGMDIC40 += parseInt(row.children[24].innerText) || 0;
                }
                if (row.children[25]) {
                    totals.SentToNodalBank40 += parseInt(row.children[25].innerText) || 0;
                }
                if (row.children[26]) {
                    totals.ReleasedByNodalBank40 += parseInt(row.children[26].innerText) || 0;
                }
                if (row.children[27]) {
                    totals.PendingForNodalBank40 += parseInt(row.children[27].innerText) || 0;
                }
            });

            function formatINR(amount) {
                return new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2
                }).format(amount);
            }

            document.getElementById('totalReceived').innerHTML = `<strong>${totals.Received}</strong>`;
            document.getElementById('totalReturned').innerHTML = `<strong>${totals.Returned}</strong>`;
            document.getElementById('totalWithdrawn').innerHTML = `<strong>${totals.Withdrawn}</strong>`;
            document.getElementById('totalPendingDIC').innerHTML = `<strong>${totals.PendingDIC}</strong>`;
            document.getElementById('totalForwardedToBankForComments').innerHTML = `<strong>${totals.ForwardedToBankForComments}</strong>`;
            document.getElementById('totalApplicationsPendingAtBankForComments').innerHTML = `<strong>${totals.ApplicationsPendingAtBankForComments}</strong>`;
            document.getElementById('totalForwardedToDLC').innerHTML = `<strong>${totals.ForwardedToDLC}</strong>`;
            document.getElementById('totalApprovedByDLC').innerHTML = `<strong>${totals.ApprovedByDLC}</strong>`;
            document.getElementById('totalRejectedByDLC').innerHTML = `<strong>${totals.RejectedByDLC}</strong>`;
            document.getElementById('totalPendingAtDLC').innerHTML = `<strong>${totals.PendingAtDLC}</strong>`;
            document.getElementById('totalForwardedToBank').innerHTML = `<strong>${totals.ForwardedToBank}</strong>`;
            document.getElementById('totalNoOfCases').innerHTML = `<strong>${totals.NoOfCases}</strong>`;
            document.getElementById('totalInvestmentInvolved').innerHTML = `<strong>${formatINR(totals.InvestmentInvolved)}</strong>`;
            document.getElementById('totalLoanInvolved').innerHTML = `<strong>${formatINR(totals.LoanInvolved)}</strong>`;
            document.getElementById('totalSubsidyInvolved').innerHTML = `<strong>${formatINR(totals.SubsidyInvolved)}</strong>`;
            document.getElementById('totalRejectedByBank').innerHTML = `<strong>${totals.RejectedByBank}</strong>`;
            document.getElementById('totalPendingAtBank').innerHTML = `<strong>${totals.PendingAtBank}</strong>`;
            document.getElementById('totalPendingAtGMDIC60').innerHTML = `<strong>${totals.PendingAtGMDIC60}</strong>`;
            document.getElementById('totalSentToNodalBank60').innerHTML = `<strong>${totals.SentToNodalBank60}</strong>`;
            document.getElementById('totalReleasedByNodalBank60').innerHTML = `<strong>${totals.ReleasedByNodalBank60}</strong>`;
            document.getElementById('totalPendingForNodalBank60').innerHTML = `<strong>${totals.PendingForNodalBank60}</strong>`;
            document.getElementById('totalPendingAtGMDIC40').innerHTML = `<strong>${totals.PendingAtGMDIC40}</strong>`;
            document.getElementById('totalSentToNodalBank40').innerHTML = `<strong>${totals.SentToNodalBank40}</strong>`;
            document.getElementById('totalReleasedByNodalBank40').innerHTML = `<strong>${totals.ReleasedByNodalBank40}</strong>`;
            document.getElementById('totalPendingForNodalBank40').innerHTML = `<strong>${totals.PendingForNodalBank40}</strong>`;
        }, 2000);
    });

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