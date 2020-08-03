@extends('layouts.system')

@section('title', $video->name)

@section('head')
    @parent
    <style>
        .ui-widget.ui-widget-content {
            background-color: #121212;
        }

        .ui-slider-horizontal .ui-slider-range {
            background-color: #CC7A00;
            top: 0;
            height: 100%;
        }

        .ui-slider .ui-slider-handle {
            position: absolute;
            z-index: 2;
            width: 1.2em;
            height: 1.2em;
            cursor: default;
            touch-action: none;
            border-radius: 50%;
            background-color: #FF9800 !important;
            border-color: #FF9800 !important;
        }
    </style>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('system.home')}}">
            <span class="fas fa-home" aria-hidden="true"></span>
            @lang('dashboard.home')
        </a>
    </li>
    @foreach($path as $father)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            <a href="{{route('system.project-details', $father->id)}}">
                <span class="fas fa-folder" aria-hidden="true"></span>
                {{$father->name}}
            </a>
        </li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page">
        <span class="fas fa-video" aria-hidden="true"></span>
        {{$video->name}}
    </li>

@endsection

@section('inner-content')

    <div class="dropdown text-right mb-2 mx-3">
        <button type="button" id="save-button" class="btn btn-outline-primary d-none text-uppercase">
            {{trans('report.save')}}
        </button>
        <button type="button" class="btn btn-md-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            Download
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('system.download-pdf', $video->id)}}" rel="noopener noreferrer"
               target="_blank">Report in PDF</a>
            <a class="dropdown-item" href="{{route('system.layout-file', $video->id)}}" rel="noopener noreferrer"
               target="_blank">Report in HTML</a>
            <a class="dropdown-item" href="{{route('system.download-json', $video->id)}}" rel="noopener noreferrer">Report
                in JSON</a>
            <a class="dropdown-item" href="{{route('system.download-excel', $video->id)}}" rel="noopener noreferrer">Report
                in EXCEL</a>
            <a class="dropdown-item" href="{{route('system.download-pptx', $video->id)}}" rel="noopener noreferrer">Report
                in PPTX</a>
        </div>
    </div>

    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content el-16dp">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="error-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loading-modal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content el-16dp">
                <div class="modal-body">
                    <div class="container d-flex align-items-center">
                        <strong>{{trans('report.analysis')}}</strong>
                        <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-lg-3">
            <div class="col mb-4">
                <div class="card el-0dp">
                    <div class="card-body">
                        <h3 class="card-title">{{trans('report.spider-chart')}}</h3>
                        <div class="smaller-charts">
                            <canvas id="radar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card el-0dp">
                    <div class="card-body">
                        <h3 class="card-title">{{trans('report.bar-chart')}}</h3>
                        <div class="smaller-charts">
                            <canvas id="bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card el-0dp">
                    <div class="card-body">
                        <h3 class="card-title">Video</h3>
                        @if(!empty($video->url))
                            <video id="video" controls preload="auto" style="max-width: 100%;">
                                <source src="{{$video->url}}" type="video/{{pathinfo($video->url,PATHINFO_EXTENSION)}}">
                            </video>
                            <p>
                                <label for="amount" style="color: #FF9800;">{{trans('dashboard.time-range')}}:</label>
                                <input type="text" id="amount" readonly
                                       style="border:none; background-color: transparent; color: #FF9800; font-weight:bold;">
                            </p>

                            <div id="slider-range" class="ui-slider-range"></div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>{{trans('report.line-chart')}}</h3>
                <div class="bigger-charts">
                    <canvas id="line"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset(mix('/js/vendor/affdex.js'))}}"></script>
    <script type="text/javascript" src="{{asset(mix('/js/emotion-analysis.js'))}}"></script>
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                let averageReport = @json($video->average_report);
                let fullReport = @json(\Emotionally\Http\Controllers\ReportController::getEmotionValues($video->report));
                let databaseReport = @json($video->report);

                let radar = document.getElementById("radar").getContext("2d");
                let line = document.getElementById("line").getContext("2d");
                let bar = document.getElementById("bar").getContext("2d");

                let saveButton = $("#save-button");

                /**
                 * Create a new radar chart.
                 */
                let radarChart = new Chart(radar, {
                    type: 'radar',
                    data: {
                        labels: Object.keys(averageReport).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [
                            {
                                label: 'Emotions',
                                data: Object.keys(averageReport).map(el => averageReport[el]),
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
                                color: 'rgba(255, 255, 255, 0.5)'
                            },
                            gridLines: {
                                color: 'rgba(255, 255, 255, 0.5)'
                            },
                            pointLabels: {
                                fontColor: 'rgba(255,255,255,0.7)',
                                fontSize: 12
                            },
                            ticks: {
                                showLabelBackdrop: false,
                                fontColor: 'rgba(255, 255, 255, 0.7)'
                            }
                        },
                        legend: {
                            labels: {
                                fontColor: '#aaa'
                            }
                        },
                        maintainAspectRatio: false
                    }
                });

                /**
                 * Create a new bar chart.
                 */
                let barChart = new Chart(bar, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(averageReport).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [
                            {
                                label: 'Emotions',
                                data: Object.keys(averageReport).map(el => averageReport[el]),
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
                                    color: 'rgba(255, 255, 255, 0.2)',
                                    zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#ccc'
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: 'rgba(255, 255, 255, 0.2)',
                                    zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#ccc'
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                fontColor: '#ccc'
                            }
                        },
                        maintainAspectRatio: false
                    }
                });

                let colors = ['#FF9800', '#5BC0EB', '#E55934', '#084887', '#9BC53D', '#F7F5FB', '#44AF69'];

                /**
                 * Create a new line chart.
                 */
                let lineChart = new Chart(line, {
                    type: 'line',
                    data: {
                        labels: fullReport.map((_, i) => i),
                        datasets: Object.keys(fullReport[0]).map((key, i) => {
                            return {
                                borderColor: colors[i],
                                pointBackgroundColor: colors[i],
                                pointBorderColor: colors[i],
                                label: key.charAt(0).toUpperCase() + key.slice(1),
                                data: fullReport.map(el => el[key]),
                                fill: false
                            };
                        })
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'rgba(255, 255, 255, 0.2)',
                                    zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#ccc'
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: 'rgba(255, 255, 255, 0.2)',
                                    zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#ccc'
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                fontColor: '#ccc'
                            }
                        },
                        maintainAspectRatio: false,
                        plugins: {
                            colorschemes: {
                                scheme: 'brewer.SetOne3'
                            },
                            zoom: {
                                pan: {
                                    enabled: true,
                                    mode: 'x',
                                    rangeMin: {
                                        // Format of min pan range depends on scale type
                                        x: 0,
                                        y: 0
                                    },
                                    rangeMax: {
                                        // Format of max pan range depends on scale type
                                        x: null,
                                        y: null
                                    }
                                },
                                zoom: {
                                    enabled: true,
                                    drag: true,
                                    mode: 'xy',

                                    rangeMin: {
                                        // Format of min zoom range depends on scale type
                                        x: null,
                                        y: 0
                                    },
                                    rangeMax: {
                                        // Format of max zoom range depends on scale type
                                        x: null,
                                        y: 1
                                    },

                                    // Speed of zoom via mouse wheel
                                    // (percentage of zoom on a wheel event)
                                    speed: 0.1
                                }
                            }
                        }
                    }
                });

                /**
                 * Update the timeline on the graph by synchronizing it with the video.
                 */

                /*
                let video = document.getElementById("video");
                video.addEventListener('timeupdate', () => {
                    lineChart.options["verticalLine"] = [{
                        "x": video.currentTime * 10,
                        "style": "rgba(255, 255, 0, 1)"
                    }];
                    lineChart.update();
                });
                */

                function timeStringToSeconds(hms) {
                    const a = hms.split(':'); // split it at the colons
                    return (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
                }

                function secondsToTimeString(totalSeconds) {
                    let hours = Math.floor(totalSeconds / 3600);
                    totalSeconds %= 3600;
                    let minutes = Math.floor(totalSeconds / 60);
                    let seconds = totalSeconds % 60;
                    return hours + ':' + minutes + ':' + seconds;
                }

                function addLeadingZerosToTimeString(timeString) {
                    const pieces = timeString.split(':');
                    const addZeros = (str) => ('0' + str).slice(-2);

                    return addZeros(pieces[0]) + ':' + addZeros(pieces[1]) + ':' + addZeros(pieces[2]);
                }

                let duration = "{{$video->duration}}";
                let end = "{{$video->end}}";
                let start = "{{$video->start}}";
                video.currentTime = timeStringToSeconds(start);
                $("#slider-range .ui-slider-range").css('background-color', '#121212');
                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: timeStringToSeconds(duration),
                    values: [timeStringToSeconds(start), timeStringToSeconds(end)],
                    highlight: true,
                    slide: function (event, ui) {
                        start = secondsToTimeString(ui.values[0]);
                        end = secondsToTimeString(ui.values[1]);
                        $("#amount").val(start + " - " + end);
                        video.currentTime = ui.values[0];
                        saveButton.removeClass('d-none');
                    },
                });
                saveButton.click(function () {
                    $("#loading-modal").modal('show');
                    EmotionAnalysis.analyzeVideo("{{$video->url}}", function (report) {
                        databaseReport = JSON.parse(report);
                        fullReport = EmotionAnalysis.getEmotionValues(databaseReport);
                        averageReport = EmotionAnalysis.getEmotionValues(EmotionAnalysis.average(fullReport));

                        lineChart.data = {
                            labels: fullReport.map((_, i) => i),
                            datasets: Object.keys(fullReport[0]).map((key, i) => {
                                return {
                                    borderColor: colors[i],
                                    pointBackgroundColor: colors[i],
                                    pointBorderColor: colors[i],
                                    label: key.charAt(0).toUpperCase() + key.slice(1),
                                    data: fullReport.map(el => el[key]),
                                    fill: false
                                };
                            })
                        };
                        lineChart.update();

                        radarChart.data = {
                            labels: Object.keys(averageReport).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                            datasets: [
                                {
                                    label: 'Emotions',
                                    data: Object.keys(averageReport).map(el => averageReport[el]),
                                    fill: true,
                                    backgroundColor: 'rgba(255, 152, 0, 0.3)',
                                    borderColor: 'rgba(255, 152, 0, 0.7)',
                                    pointBackgroundColor: 'rgba(255, 152, 0, 1)',
                                    pointBorderColor: 'rgba(255, 255, 255, 0.9)'
                                }
                            ]
                        };
                        radarChart.update();

                        barChart.data = {
                            labels: Object.keys(averageReport).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                            datasets: [
                                {
                                    label: 'Emotions',
                                    data: Object.keys(averageReport).map(el => averageReport[el]),
                                    fill: false,
                                    barPercentage: 0.25,
                                    backgroundColor: 'rgba(255, 152, 0, 1)',
                                    hoverBackgroundColor: 'rgba(255, 152, 0, 0.7)'
                                }
                            ]
                        };
                        barChart.update();

                        $.post('{{route('system.edit-video-duration', $video->id)}}', {
                            '_method': 'PUT',
                            '_token': '{{csrf_token()}}',
                            'start': addLeadingZerosToTimeString(start),
                            'end': addLeadingZerosToTimeString(end),
                            'report': JSON.stringify(databaseReport)
                        })
                            .done(out => {
                                out = JSON.parse(out);
                                if (out['done']) {
                                    saveButton.addClass('d-none');
                                } else {
                                    $('#error-modal').modal('show');
                                    let errorMessage = '<ul>';
                                    Object.keys(out.errors).forEach(key => errorMessage += '<li>' + out.errors[key] + '</li>');
                                    errorMessage += '</ul>';
                                    $('#error-text').html(errorMessage);
                                }
                            })
                            .fail(() => {
                                $('#error-modal').modal('show');
                                $('#error-text').text("We're sorry... An unknown error occurred...");
                            })
                            .always(() => {
                                $("#loading-modal").modal('hide');
                            });

                    }, {start: timeStringToSeconds(start), stop: timeStringToSeconds(end)});
                });
                video.addEventListener('timeupdate', () => {
                    if (video.currentTime >= timeStringToSeconds(end)) {
                        video.pause();
                        video.currentTime = timeStringToSeconds(start);
                    }
                });
                $("#amount").val(secondsToTimeString($("#slider-range").slider("values", 0)) + " - " + secondsToTimeString($("#slider-range").slider("values", 1)));
            });
        })(jQuery);
    </script>
@endsection
