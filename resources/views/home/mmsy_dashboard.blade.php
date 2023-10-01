@extends('layouts.applicant')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('content')
    @include('shared.front-end.applicant_header')

    <div class="container">
        
    
        <div class="row mt-4">
        {{-- Firt Row --}}
        <div class="card col-lg-3 col-md-6 mt-4 mb-4" >
            <h6 class="text-center p-3">Application Recieved</h6>
                @if($fyWiseapplicationCount)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">Financial Year : <span><strong>Counts</strong></span><span>Action</span></li>
                        @foreach($fyWiseapplicationCount as $dataPoint)
                            <li class="list-group-item text-center">{{ $dataPoint['Year'] }} : <span><strong>{{ $dataPoint['Received Application'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => $dataPoint['Year'], 'status_id' => 308, 'type' => 'Application Recieved']) }}">View</a></span></li>
                        @endforeach
                        <li class="list-group-item text-center">Total Counts: <span><strong>{{ $fyWiseapplicationCountTotals['Received Application'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => '2023-2024', 'status_id' => 308, 'type' => 'Application Recieved']) }}">View</a></span></li>
                    </ul>
                @endif
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
                <div class="card-header p-0 position-relative mt-n4 z-index-2 bg-transparent">
                    <div class="bg-gradient shadow border-radius-lg py-3 pe-1">
                        <h6 class="text-center p-3">Social Category wise No of Application
                            </h6>
                        <div class="chart chart-wrapper">
                            <canvas id="myPieChart" style="position: relative; height:40vh; width:80vw"
                        ></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-lg-3 col-md-6 mt-4 mb-4">
            <h6 class="text-center p-3">Forwarded To Bank</h6>
            @if($fyWiseapplicationCount)
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">Financial Year : <span><strong>Counts</strong></span><span>Action</span></li>
                    @foreach($fyWiseapplicationCount as $dataPoint)
                        <li class="list-group-item text-center">{{ $dataPoint['Year'] }} : <span><strong>{{ $dataPoint['Forwarded To Bank'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => $dataPoint['Year'], 'status_id' => 311, 'type' => 'Forwarded To Bank']) }}">View</a></span></li>
                    @endforeach
                    <li class="list-group-item text-center">Total Counts: <span><strong>{{ $fyWiseapplicationCountTotals['Forwarded To Bank'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => $dataPoint['Year'], 'status_id' => 311, 'type' => 'Forwarded To Bank']) }}">View</a></span></li>
                </ul>
            @endif
        </div>
        {{-- Firt Row --}}

            <div class="card col-lg-3 col-md-6 mt-4 mb-4" >
                <h6 class="text-center p-3">60% Subsidy Released</h6>
                @if($fyWiseapplicationCount)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">Financial Year : <span><strong>Counts</strong></span><span>Action</span></li>
                        @foreach($fyWiseapplicationCount as $dataPoint)
                            <li class="list-group-item text-center">{{ $dataPoint['Year'] }} : <span><strong>{{ $dataPoint['60% Subsidy Released'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => $dataPoint['Year'], 'status_id' => 315, 'type' => '60% Subsidy Released']) }}">View</a></span></li>
                        @endforeach
                        <li class="list-group-item text-center">Total Counts: <span><strong>{{ $fyWiseapplicationCountTotals['60% Subsidy Released'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => '2023-2024', 'status_id' => 315, 'type' => '60% Subsidy Released']) }}">View</a></span></li>
                    </ul>
                @endif
            </div>
            <div class="col-lg-3 col-md-6 mt-4 mb-4">
                <div class="card z-index-2 ">
                    <div class="card-header p-0 position-relative mt-n4 z-index-2 bg-transparent">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-bars" class="chart-canvas" height="170" style="display: block; box-sizing: border-box; height: 170px; width: 281.7px;" width="281"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0 ">Applications</h6>
                        <p class="text-sm ">Last Week Data</p>
                        <hr class="dark horizontal">
                        <div class="d-flex ">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm"> Recently updated</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mt-4 mb-4">
                <div class="card z-index-2  ">
                    <div class="card-header p-0 position-relative mt-n4 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="170"
                                    style="display: block; box-sizing: border-box; height: 170px; width: 281.7px;"
                                    width="281"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0 "> Monthly Applications </h6>
                        <p class="text-sm ">Last 12 months data </p>
                        <hr class="dark horizontal">
                        <div class="d-flex ">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm"> Recently updated </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-lg-3 col-md-6 mt-4 mb-4">
                <h6 class="text-center p-3">Total Subsidy Released</h6>
                @if($fyWiseapplicationCount)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">Financial Year : <span><strong>Counts</strong></span><span>Action</span></li>
                        @foreach($fyWiseapplicationCount as $dataPoint)
                            <li class="list-group-item text-center">{{ $dataPoint['Year'] }} : <span><strong>{{ $dataPoint['Total Subsidy Released'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => $dataPoint['Year'], 'status_id' => 315, 'type' => 'Total Subsidy Released']) }}">View</a></span></li>
                        @endforeach
                        <li class="list-group-item text-center">Total Counts: <span><strong>{{ $fyWiseapplicationCountTotals['Total Subsidy Released'] }}</strong></span><span><a href="{{ route('extractcounts', ['fy' => '2023-2024', 'status_id' => 315, 'type' => 'Total Subsidy Released']) }}">View</a></span></li>
                    </ul>
                @endif
            </div>
           
        </div>
    </div>
@endsection
<style>
    .chart-wrapper{
        display: block !important; box-sizing: border-box  !important; height: 350px !important; width: 350.4px !important; margin: auto  !important;
    }
    li.list-group-item.text-center {
    display: flex;
    justify-content: space-between;
}
</style>
@section('scripts')
    <script>
        const ready = () => {
            var ctx = document.getElementById("chart-bars").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: {!! json_encode($weeklyLabels ? $weeklyLabels : '') !!},
                    datasets: [{
                        label: "Applications",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: {!! json_encode($weeklyCounts ? $weeklyCounts : 0) !!},
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });


            var ctx2 = document.getElementById("chart-line").getContext("2d");

            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: {!! json_encode($monthlyLabels ? $monthlyLabels : '') !!},
                    datasets: [{
                        label: "Total Application",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: {!! json_encode($monthlyCounts ? $monthlyCounts : 0) !!},
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
            // Pie Chart
            const xValues = ["GENERAL", "SC", "ST", "OBC", "MINORITY"];
            const yValues = {!! json_encode($categoryCountsForPie ? $categoryCountsForPie : '') !!};
            const barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9",
            "#1e7145"
            ];
            var ctx5 = document.getElementById("myPieChart").getContext("2d");
            new Chart(ctx5, {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                title: {
                display: true,
                responsive: true,
                text: "Social Category wise data"
                },
            }
            });
        };
        document.readyState == 'loading' ? document.addEventListener('DOMContentLoaded', ready) : ready();
    </script>

@endsection
