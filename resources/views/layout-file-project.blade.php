@extends('layouts.blank')

@section('title')
    {{trans('report.project-report') . ': ' . $project->name}}
    @endsection

@section('body')

    <div class="container w-75">
        <div class="container">
            <div class="row">
                <div class="col text-left">
                    <img src="{{asset('/logo.png')}}" width="64px"
                         height="64px"
                         alt="Emotionally's logo">
                    <img src="{{asset('/app_name_black.svg')}}" width="90px"
                         height="90px"
                         alt="Emotionally">
                </div>
                <div class="col text-right mt-3 mr-2">
                    <img src="{{asset('/fsc_logo_text_dark.png')}}" width="180px"
                         alt="FSC - Five students of computer science">
                </div>
            </div>
        </div>
        <div class="text-center my-4">
            <h1>{{trans('report.project-name')}}: {{ $project->name }}</h1>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <table class="table" style="color:black">
                    <caption class="sr-only">{{trans('report.project-report')}}</caption>
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">{{trans('report.creator')}}</th>
                        <th scope="col">{{trans('report.emoji')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            {{ $project->creator->name }}
                            {{ $project->creator->surname }}
                        </td>

                        <td> {{\Emotionally\Http\Controllers\ReportController::get_emoji(\Emotionally\Http\Controllers\ReportController::highestEmotion($project->report))}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h3>{{trans('report.spider-chart')}}</h3>
                <div class="smaller-charts">
                    <canvas id="radar"></canvas>
                </div>
            </div>
            <div class="col-6">
                <h3>{{trans('report.bar-chart')}}</h3>
                <div class="smaller-charts">
                    <canvas id="bar"></canvas>
                </div>
            </div>
        </div>
        <footer>
            <div class="copyright text-white-50 my-3">
                <div class="container-fluid px-3">
                    <p class="d-inline-block mt-md-1" style="color: black;">
                        Copyright &copy; 2019-{{date('Y')}},
                        <a href="https://F-S-C.github.io/" rel="noopener noreferrer" target="_blank">FSC</a>.
                        @lang('metadata.copyright')
                    </p>
                </div>
            </div>
        </footer>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            $(document).ready(function () {
                let radarReady = false, barReady = false;

                let onLoadedCallback = function () {
                    if (radarReady && barReady) {
                        radarReady = barReady = false;
                        @if(isset($to_pdf) && $to_pdf)
                        window.print();
                        @endif
                    }
                };

                let data = @json(\Emotionally\Http\Controllers\ReportController::getEmotionValues($project->report));
                let radar = document.getElementById("radar").getContext("2d");

                let bar = document.getElementById("bar").getContext("2d");

                /**
                 * Create a new radar chart.
                 */
                new Chart(radar, {
                    type: 'radar',
                    data: {
                        labels: Object.keys(data).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [
                            {
                                label: 'Emotions',
                                data: Object.keys(data).map(el => data[el]),
                                fill: true,
                                backgroundColor: 'rgba(255, 152, 0, 0.3)',
                                borderColor: 'rgba(255, 152, 0, 0.7)',
                                pointBackgroundColor: 'rgba(255, 152, 0, 1)',
                                pointBorderColor: 'rgba(255, 255, 255, 0.9)'
                            }
                        ]
                    },
                    options: {
                        scale: {
                            angleLines: {
                                color: 'rgba(0, 0, 0, 0.5)'
                            },
                            gridLines: {
                                color: 'rgba(0, 0, 0, 0.5)'
                            },
                            pointLabels: {
                                fontColor: 'rgba(0, 0, 0, 0.7)',
                                fontSize: 12
                            },
                            ticks: {
                                showLabelBackdrop: false,
                                fontColor: 'rgba(0, 0, 0, 0.7)'
                            }
                        },
                        legend: {
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0,
                            onComplete: function () {
                                radarReady = true;
                                onLoadedCallback();
                            },
                        }
                    },
                });

                /**
                 * Create a new bar chart.
                 */
                new Chart(bar, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [
                            {
                                label: 'Emotions',
                                data: Object.keys(data).map(el => data[el]),
                                fill: false,
                                barPercentage: 0.25,
                                backgroundColor: 'rgba(255, 152, 0, 1)',
                                hoverBackgroundColor: 'rgba(255, 152, 0, 0.7)'
                            }
                        ]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'rgba(0, 0, 0, 0.2)',
                                    zeroLineColor: 'rgba(0, 0, 0, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#000'
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: 'rgba(0, 0, 0, 0.2)',
                                    zeroLineColor: 'rgba(0, 0, 0, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#000'
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0,
                            onComplete: function () {
                                barReady = true;
                                onLoadedCallback();
                            },
                        }
                    }
                });
            });
        })($);
    </script>
@endsection
