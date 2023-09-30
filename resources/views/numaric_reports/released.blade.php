@extends('layouts.admin')

@section('content')
<div class="row align-items-center master_report">
    <h3>{{ $title }}</h3>
    <div class="col-md-12">
        <x-cards.card>
            <div class="header-custom">
                <x-cards.header class="px-md-4 py-md-3">
                    <div class="row">
                        <x-filters.reports_filter :statusId="$statusId" :constituencies="$constituencies" :districts="$districts" :tehsils="$tehsils" :blocks="$blocks" :panchayatWards="$panchayatWards">
                        </x-filters.reports_filter>
                    </div>
                </x-cards.header>
            </div>
            <x-cards.body>
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="table-responsive container">
                            <table class="table table-bordered table-hover table-condensed header">
                                <div class="row export-btns">
                                    <a href="{{ route('numaric_reports.exportReports','allStatus') }}" style="width: 150px" class="btn btn-success ml-4">Download</a>
                                    <button id="printButton" style="width: 150px" class="btn btn-primary">Print</button>
                                </div>
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2">Sr. No.</th>
                                        <th scope="col" rowspan="2">District</th>
                                        <th scope="col" rowspan="2">Year</th>
                                        @foreach ($statusCodes as $status)
                                            <th scope="col" rowspan="2" class="text-right">{{ $status['name'] }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totals = array_fill_keys(array_column($statusCodes, 'name'), 0);
                                    @endphp

                                    @foreach ($reportData as $districtIndex => $district)
                                        @if(isset($district['Year']))
                                            @foreach ($district['Year'] as $yearData)
                                                <tr>
                                                    @if ($loop->first)
                                                        <td rowspan="{{ count($district['Year']) }}">{{ $districtIndex + 1 }}</td>
                                                        <td rowspan="{{ count($district['Year']) }}">{{ $district['District'] }}</td>
                                                    @endif
                                                    <td>{{ $yearData['Year'] }}</td>
                                                    @foreach ($statusCodes as $status)
                                                    <td class="text-right">
                                                        <a href="master_report/applications/all/0?district_id[]={{ $district['DistrictId'] }}&fy={{ $yearData['Year'] }}&status_id={{ $status['id'] }}">
                                                            {{ $yearData[$status['name']] }}
                                                        </a>
                                                    </td>
                                                        @php
                                                            $totals[$status['name']] += $yearData[$status['name']];
                                                        @endphp
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach

                                    <tr style="background: pink; font-weight:bold">
                                        <th scope="row" colspan="3" class="text-center">Total</th>
                                        @foreach ($statusCodes as $status)
                                            <td class="text-right">{{ $totals[$status['name']] }}</td>
                                        @endforeach
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
    .export-btns a,.export-btns button{
        margin-left:15px;
    }
    .export-btns{
        display: flex;
    }
    .header {
        position: sticky;
        top:0;
    }
    .container {
        width: 100%;
        /* height: 800px; */
        overflow: auto;
    }
    @media print {
        .header-custom, body .navbar, body .export-btns{
            display: none;
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
