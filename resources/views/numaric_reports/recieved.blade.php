
@extends('layouts.admin')

@section('content')
<div class="row align-items-center master_report">
    <h3>{{ $title }}</h3>
    <div class="col-md-12">
        <x-cards.card >
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
                    <div class="card mb-3">
                        <table class="table table-bordered table-hover table-striped table-condensed" id="table">
                            <div class="row export-btns">
                                <a href="{{ route('numaric_reports.exportReports','recieved') }}" style="width: 150px" class="btn btn-success ml-4">Download</a>
                                <button id="printButton" style="width: 150px" class="btn btn-primary">Print</button>
                            </div>

                            <thead>
                                <tr>
                                    <th scope="col" rowspan="2">Sr. No.</th>
                                    <th scope="col" rowspan="2">District</th>
                                    <th scope="col" rowspan="2">Year</th>
                                    <th scope="col" rowspan="2" class="text-right">Received</th>
                                    <th scope="col" rowspan="2" class="text-right">Approved</th>
                                    <th scope="colgroup" colspan="2" class="text-center">Rejected</th>
                                    <th scope="colgroup" colspan="2" class="text-center">Pending</th>
                                </tr>
                                <tr>
                                    <th class="text-right">By DLC</th>
                                    <th class="text-right">By Bank</th>
                                    <th class="text-right">For DLC</th>
                                    <th class="text-right">At Bank</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportData as $district)
                                    @if(isset($district['Year']))
                                        @php
                                            $displayDistrictName = true;
                                        @endphp

                                        @foreach ($district['Year'] as $yearData)
                                            <tr>
                                                @if ($displayDistrictName)
                                                    <td rowspan="{{ count($district['Year']) }}">{{ $loop->parent->index + 1 }}</td>
                                                    <td rowspan="{{ count($district['Year']) }}">{{ $district['District'] }}</td>
                                                    @php
                                                        $displayDistrictName = false; 
                                                    @endphp
                                                @endif
                                                <td>{{ $yearData['Year'] }}</td>
                                                <td class="text-right">
                                                    <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}">
                                                        {{ $yearData['Received'] }}
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=100">
                                                        {{ $yearData['Approved'] }}
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=310">
                                                        {{ $yearData['Rejected By DLC'] }}
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=304">
                                                        {{ $yearData['Rejected By Bank'] }}
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=309">
                                                        {{ $yearData['Pending For DLC'] }}
                                                    </a>
                                                </td>
                                                 <td class="text-right">
                                                    <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id=308">
                                                        {{ $yearData['Pending At Bank'] }}
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <b>
                                                    {{ $yearData['Received'] + $yearData['Approved'] + $yearData['Rejected By DLC'] + $yearData['Rejected By Bank'] + $yearData['Pending For DLC'] + $yearData['Pending At Bank'] }}
                                                    </b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                    <!-- <th scope="row" colspan="3" class="text-center">Total</th>
                                    <td class="text-right"><b>{{ $totals['Received'] }}</b></td>
                                    <td class="text-right"><b>{{ $totals['Approved'] }}</b></td>
                                    <td class="text-right"><b>{{ $totals['RejectedByDLC'] }}</b></td>
                                    <td class="text-right"><b>{{ $totals['RejectedByBank'] }}</b></td>
                                    <td class="text-right"><b>{{ $totals['PendingForDLC'] }}</b></td>
                                    <td class="text-right"><b>{{ $totals['PendingAtBank'] }}</b></td>
                                    <td class="text-right"><b>{{ $totals['Received'] + $totals['Approved'] + $totals['RejectedByDLC'] + $totals['RejectedByBank'] + $totals['PendingForDLC'] + $totals['PendingAtBank'] }}</b></td> -->
                                </tr>
                            </tbody>
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
    .export-btns a,.export-btns button{
        margin-left:15px;
    }
    .export-btns{
        display: flex;
    }
    @media print {
        .header-custom, body .navbar, body .export-btns{
            display: none;
        }
    }
    .sidenav, .navbar{
        display: none !important;
    }
    @media (min-width: 1200px) {
    .sidenav.fixed-start+.main-content {
        margin-left: 0 !important;
    }
}

</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css"/>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js" defer="defer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('printButton').addEventListener('click', function () {
            window.print(); // Trigger the browser's print dialog
        });
    });
</script>


