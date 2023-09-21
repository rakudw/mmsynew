<!-- resources/views/exports/numeric_report.blade.php -->

<table>
    <thead>
        <tr>
            <th scope="col" rowspan="2">Sr. No.</th>
            <th scope="col" rowspan="2">District</th>
            <th scope="col" rowspan="2">Year</th>
            <th scope="col" rowspan="2">Received</th>
            <th scope="col" rowspan="2">Approved</th>
            <th scope="colgroup" colspan="2">Rejected</th>
            <th scope="colgroup" colspan="2">Pending</th>
        </tr>
        <tr>
            <th>By DLC</th>
            <th>By Bank</th>
            <th>For DLC</th>
            <th>At Bank</th>
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
                        <td>{{ $yearData['Received'] }}</td>
                        <td>{{ $yearData['Approved'] }}</td>
                        <td>{{ $yearData['Rejected By DLC'] }}</td>
                        <td>{{ $yearData['Rejected By Bank'] }}</td>
                        <td>{{ $yearData['Pending For DLC'] }}</td>
                        <td>{{ $yearData['Pending At Bank'] }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        <tr>
            <th colspan="3">Total</th>
            <th>{{ $totals['Received'] }}</th>
            <th>{{ $totals['Approved'] }}</th>
            <th>{{ $totals['RejectedByDLC'] }}</th>
            <th>{{ $totals['RejectedByBank'] }}</th>
            <th>{{ $totals['PendingForDLC'] }}</th>
            <th>{{ $totals['PendingAtBank'] }}</th>
        </tr>
    </tbody>
</table>
