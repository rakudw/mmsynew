@extends('layouts.applicant')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('content')
    @include('shared.front-end.applicant_header')

    <div class="container">
        <h3 class="text-center mt-4 mb-4"> District Wise Data for Total Application Received in FY (2021-2022) </h4>
            <table class="table table-bordered table-hover table-striped table-condensed" id="table">
                <thead>
                    <tr>
                        <th scope="col" >Sr. No.</th>
                        <th scope="col" >District</th>
                        <th scope="col" >Year</th>
                        <th scope="col" >GENERAL</th>
                        <th scope="col" >SC</th>
                        <th scope="col" >ST</th>
                        <th scope="col" >OBC</th>
                        <th scope="col" >MINORITY</th>
                        <th scope="col" >Total</th>
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
                                    <td>{{ $loop->parent->index + 1 }}</td>
                                    <td >{{ $district['District'] }}</td>
                                    <td>{{ $yearData['Year'] }}</td>
                                    <td>{{ $yearData['General'] }}</td>
                                    <td>{{ $yearData['SC'] }}</td>
                                    <td>{{ $yearData['ST'] }}</td>
                                    <td>{{ $yearData['OBC'] }}</td>
                                    <td>{{ $yearData['Minority'] }}</td>
                                    <td class="text-right">
                                        <b>
                                        {{ $yearData['General'] + $yearData['SC'] + $yearData['ST'] + $yearData['OBC'] + $yearData['Minority'] }}
                                        </b>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                        <th scope="row" colspan="3" class="text-center">Total</th>
                        <td ><b>{{ $totals['General'] }}</b></td>
                        <td ><b>{{ $totals['SC'] }}</b></td>
                        <td ><b>{{ $totals['ST'] }}</b></td>
                        <td ><b>{{ $totals['OBC'] }}</b></td>
                        <td ><b>{{ $totals['Minority'] }}</b></td>
                        <td ><b>{{ $totals['General'] + $totals['SC'] + $totals['ST'] + $totals['OBC'] + $totals['Minority'] }}</b></td>
                    </tr>
                </tbody>
            </table>
        
    </div>
@endsection
<style>
    tr{
        line-height: 50px;
    }
</style>
@section('scripts')
@endsection
