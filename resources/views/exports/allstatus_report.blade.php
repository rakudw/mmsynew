<table>
    <thead>
        <tr>
            <th scope="col">Sr. No.</th>
            <th scope="col">District</th>
            <th scope="col">Year</th>
            @foreach ($statusCodes as $status)
                <th scope="col" class="text-right">{{ $status['name'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $totals = array_fill_keys(array_column($statusCodes, 'name'), 0);
        @endphp

        @foreach ($reportData as $districtIndex => $district)
            @if(isset($district['Year']))
                @foreach ($district['Year'] as $yearIndex => $yearData)
                    <tr>
                        @if ($yearIndex === 0)
                            <td rowspan="{{ count($district['Year']) }}">{{ $districtIndex + 1 }}</td>
                            <td rowspan="{{ count($district['Year']) }}">{{ $district['District'] }}</td>
                        @endif
                        <td>{{ $yearData['Year'] }}</td>
                        @foreach ($statusCodes as $status)
                            <td class="text-right">{{ $yearData[$status['name']] }}</td>
                            @php
                                $totals[$status['name']] += $yearData[$status['name']];
                            @endphp
                        @endforeach
                    </tr>
                @endforeach
            @endif
        @endforeach

        <tr style="background: pink; font-weight:bold">
            <th scope="row" colspan="2" class="text-center">Total</th>
            <th></th> 
            @foreach ($statusCodes as $status)
                <td class="text-right">{{ $totals[$status['name']] }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
