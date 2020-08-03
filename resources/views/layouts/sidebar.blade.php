@extends('layouts.master')

@section('head')
    @parent
    <style>
        #main {
            padding: 15px 15px 64px;
            width: 100%;
            min-height: 100%;
            transition: all 0.3s;
        }

        #main {
            width: 100%;
        }

        .input-color {
            background-color: #232323 !important;
            color: white !important;
        }

        .modal-close {
            color: white !important;
            background-color: transparent;
            border: none;
        }

        .modal-close:hover {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }
    </style>
    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet"/>
    <link href="{{asset('css/vendor/videojs.record.min.css')}}" rel="stylesheet"/>

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
@endsection

@section('body')
    <div class="wrapper">
        <nav class="sidebar el-8dp scrollbar-inner" id="main-navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand text-center w-100  d-flex" style="text-decoration: none;"
                   href="{{route('system.home')}}">
                    <img src="{{asset('/logo.png')}}" width="64"
                         height="64"
                         class="d-inline-block d-md-inline-block align-center mx-auto" alt="Emotionally's logo">
                    <img src="{{asset('/app_name.svg')}}" width="16"
                         height="64"
                         class="d-none d-md-inline-block flex-fill" alt="Emotionally">
                </a>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item active" id="side-home-btn">
                    @if(Auth::user()->projects->isNotEmpty())
                        <div class="btn-group collapse-button-container">
                            <a type="button" class="nav-link collapse-button d-none d-md-block" data-toggle="collapse"
                               href="#projects-container"
                               role="button" aria-expanded="false" aria-controls="projects-container"></a>
                            <a class="nav-link text-center text-md-left" href="{{route('system.home')}}">
                                <span aria-hidden="true" class="fas fa-home mr-0 mr-md-1 text-md-center"></span>
                                <span class="d-none d-md-inline">{{trans('dashboard.projects')}}</span>
                            </a>
                        </div>
                    @else
                        <a class="nav-link text-center text-md-left" href="{{route('system.home')}}">
                            <span aria-hidden="true" class="fas fa-home mr-0 mr-md-1 text-md-center"></span>
                            <span class="d-none d-md-inline">Projects</span>
                        </a>
                    @endif
                    <ul class="collapse el-3dp nav flex-column flex-nowrap" id="projects-container">
                        @each('partials.project-tree-view', Auth::user()->projects->where('father_id', null), 'main_project')
                    </ul>
                </li>
                <li class="nav-item">
                    <div class="btn-group collapse-button-container">
                        <a type="button" class="nav-link collapse-button hide-xs-icon d-block d-md-block"
                           data-toggle="collapse"
                           href="#languages-container"
                           role="button" aria-expanded="false" aria-controls="languages-container">
                            <span aria-hidden="true"
                                  class="d-block d-md-none fas fa-globe mr-0 mr-md-1 text-md-center"></span>
                        </a>
                        <a class="nav-link text-center text-md-left d-none d-md-block" data-toggle="collapse"
                           href="#languages-container" role="button" aria-expanded="false"
                           aria-controls="languages-container">
                            <span aria-hidden="true" class="fas fa-globe mr-0 mr-md-1 text-md-center"></span>
                            <span class="d-none d-md-inline">@lang('navbar.language')</span>
                        </a>
                    </div>
                    <ul class="collapse el-3dp nav flex-column flex-nowrap" id="languages-container">
                        <li class="nav-item ml-0 text-center text-md-left ml-md-4">
                            <a class="nav-link"
                               href="{{route('language.set', 'it')}}">
                                <span aria-hidden="true" class="d-inline d-md-none">ITA</span>
                                <span class="d-none d-md-inline">@lang('navbar.italian')</span>
                            </a>
                        </li>
                        <li class="nav-item ml-0 text-center text-md-left ml-md-4">
                            <a class="nav-link"
                               href="{{route('language.set', 'en')}}">
                                <span aria-hidden="true" class="d-inline d-md-none">ENG</span>
                                <span class="d-none d-md-inline">@lang('navbar.english')</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item text-center text-md-left" id="side-profile-btn">
                    <a class="nav-link" href="{{route('system.profile')}}">
                        <span aria-hidden="true" class="fas fa-user mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">{{trans('dashboard.profile')}}</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <span aria-hidden="true" class="fas fa-sign-out-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Logout</span>
                    </a>
                </li>
            </ul>

        </nav>
        <div class="content sidebar-content">
            <nav class="navbar navbar-expand-lg navbar-dark el-0dp" style="padding: 20px 30px;" aria-label="navbar">
                <div class="form-inline my-2 my-lg-0">
                    @if(! (strpos($_SERVER['REQUEST_URI'], "project") || strpos($_SERVER['REQUEST_URI'], "profile") || strpos($_SERVER['REQUEST_URI'], "video")))
                        <input class="form-control mr-sm-2 rounded-pill" type="search"
                               placeholder="{{trans('dashboard.search')}}"
                               aria-label="{{trans('dashboard.search')}}" id="search-bar">
                    @elseif(Request::segment(2) == 'project' && isset($project) && Request::segment(3) != 'report')
                        <button onclick="window.location.href = '{{route('system.report-project', $project->id)}}';"
                                class="rounded ml-auto btn btn-outline-primary d-block text-uppercase">
                            @lang('dashboard.report')
                        </button>
                    @endif
                </div>
                <div class="ml-auto btn-group dropleft">
                    @if(!(strpos($_SERVER['REQUEST_URI'], "report") || strpos($_SERVER['REQUEST_URI'], "video") || strpos($_SERVER['REQUEST_URI'], "profile")))
                        <button class="btn btn-outline-primary rounded-pill mr-0 mr-md-4" type="button" id="add-video"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                title="{{trans('dashboard.upload_video')}}">
                            <span class="fa fa-plus-circle mr-1" aria-hidden="true"></span>
                            {{trans('dashboard.add')}}
                        </button>
                    @endif
                    <div class="dropdown-menu" aria-labelledby="add-video">
                        @if(isset($project))
                            @if( $project->father_id == null)
                                <button class="dropdown-item" id="create-project" data-toggle="modal"
                                        data-target="create-project-modal"
                                        data-modal="create-project-modal">{{trans('dashboard.add_project')}}
                                </button>
                                @if(Request::segment(2) == "project")
                                    <div class="dropdown-divider"></div>
                                @endif
                            @endif
                        @else
                            <button class="dropdown-item" id="create-project" data-toggle="modal"
                                    data-target="create-project-modal"
                                    data-modal="create-project-modal">{{trans('dashboard.add_project')}}
                            </button>
                        @endif
                        @if( Request::segment(2) == "project")
                            <button class="dropdown-item" id="upload-video" data-toggle="modal"
                                    data-target="upload-video-modal"
                                    data-modal="upload-video-modal">{{trans('dashboard.upload_video')}}</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" id="realtime-video" data-toggle="modal"
                                    data-target="realtime-video-modal"
                                    data-modal="realtime-video-modal">{{trans('dashboard.realtime_video')}}</button>
                        @endif
                    </div>
                    <div aria-label="Your profile" class="ml-auto my-2 my-lg-0 d-none d-md-flex clickable"
                         data-href="{{route('system.profile')}}" role="button">
                        <img alt="" aria-hidden="true" class="rounded-circle p-1 border border-text" width="40"
                             height="40"
                             src="https://robohash.org/{{Auth::user()->email}}?set=set3"/>
                        <div class="ml-2">
                        <span aria-label="Your name" id="user-profile-name-surname"
                              class="font-weight-bold text-white d-block">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
                            <small aria-label="Your email" class="d-block">{{Auth::user()->email}}</small>
                        </div>
                    </div>
                </div>
                {{--                <button class="navbar-toggler" type="button" data-toggle="collapse"--}}
                {{--                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"--}}
                {{--                        aria-expanded="false" aria-label="Toggle navigation">--}}
                {{--                    <span class="navbar-toggler-icon"></span>--}}
                {{--                </button>--}}

                {{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
                {{--                    <ul class="navbar-nav mr-auto">--}}
                {{--                        <li class="nav-item active">--}}
                {{--                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a class="nav-link" href="#">Link</a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </div>--}}
            </nav>
            <!-- Modal 1  video-->
            @if(isset($project))
                <div class="modal fade" id="upload-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content el-16dp">
                            <div class="modal-header">
                                <h5 class="modal-title">{{trans('dashboard.upload_video')}}</h5>
                            </div>
                            <div class="modal-body">
                                <div id="video-upload-complete" class="alert alert-success" role="alert"
                                     aria-atomic="true"
                                     style="display:none;">
                                    {{trans('dashboard.upload_successful')}}
                                </div>
                                <div id="video-upload-notcomplete" class="alert alert-danger" role="alert"
                                     aria-atomic="true"
                                     style="display:none;">
                                    {{trans('dashboard.upload_failed')}}
                                </div>
                                <form method="POST" action="{{ route('system.videoUpload') }}"
                                      enctype="multipart/form-data"
                                      id="video-form">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text input-color"
                                              for="customVideo">{{trans('dashboard.upload_video')}}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input multiple="multiple" type="file" class="custom-file-input input-color"
                                                   id="customVideo" name="videos[]"
                                                   accept="video/*">
                                            <label id="customVideoLabel" class="custom-file-label input-color "
                                                   for="customVideo">{{trans('dashboard.choose_file')}}</label>
                                        </div>
                                    </div>
                                    <input type="text" name="project_id" value="{{$project->id}}" hidden>
                                    <div class="collapse multi-collapse" id="duration-fps-collapse-menu">

                                        <div class="card card-body el-16dp">
                                            <div class="form-inline">
                                                <label for="framerate-video"
                                                       id="framerate-video-text">{{trans('dashboard.framerate')}}:
                                                    30</label>
                                                <input type="range" class="custom-range" id="framerate-video"
                                                       name="framerate"
                                                       min="1" max="60" value="30" step="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" id="close-video" class="btn btn-secondary"
                                                data-dismiss="modal">
                                            {{trans('dashboard.close')}}
                                        </button>
                                        <input type="submit" value="{{ trans('dashboard.upload') }}"
                                               class="btn btn-primary">
                                    </div>
                                </form>
                                <div id="progress-container" style="display: none;">
                                    <div class="progress">
                                        <div id="progress"
                                             class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 0%"></div>
                                    </div>
                                    <p id="uploading-text-container"
                                       class="text-center"> {{trans('dashboard.uploading')}}
                                        <span id="upload-text"></span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!---Modal 2 Realtime--->
                <div class="modal fade" id="realtime-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content el-16dp">
                            <div class="modal-header">
                                <h5 class="modal-title">{{trans('dashboard.realtime_video')}}</h5>
                            </div>
                            <div class="modal-body el-16dp">

                                <div id="realtimevideo-upload-complete" class="alert alert-success" role="alert"
                                     aria-atomic="true"
                                     style="display:none;">
                                    {{trans('dashboard.upload_successful')}}
                                </div>
                                <div id="realtimevideo-upload-notcomplete" class="alert alert-danger" role="alert"
                                     aria-atomic="true"
                                     style="display:none;">
                                    {{trans('dashboard.upload_failed')}}
                                </div>

                                <div id="realtime-body" class="card-body">
                                    <video id="vid1" class="video-js vjs-default-skin mb-1" width="400"
                                           height="250"></video>
                                    <button id="next-realtime" class="btn btn-primary float-right"
                                            disabled>{{ trans('dashboard.next') }}</button>
                                    <button id="close-realtime" data-dismiss="modal"
                                            class="btn btn-secondary float-right mx-1">{{ trans('dashboard.close') }}</button>
                                </div>

                                <form method="POST" action="{{ route('system.realtimeUpload') }}"
                                      enctype="multipart/form-data"
                                      id="realtimevideo-form">
                                    @csrf
                                    <input type="hidden" id="realtimevideo-file" name="video">
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <input type="hidden" id="duration" name="duration">

                                    <div id="title-fps-menu" style="display: none;">
                                        <div class="form-group">
                                            <label for="title">{{trans('dashboard.title')}}</label>
                                            <input type="text" id="title" name="title"
                                                   class="form-control input-color" required>
                                        </div>
                                        <div class="form-inline">
                                            <label for="framerate-realtime"
                                                   id="realtime-framerate-text">{{trans('dashboard.framerate')}}:
                                                30</label>
                                            <input type="range" class="custom-range" id="framerate-realtime"
                                                   name="framerate"
                                                   min="1" max="60" value="30" step="1">
                                        </div>
                                    </div>

                                    <div id="realtime-submit-close" style="display: none;" class="mt-3 modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">
                                            {{trans('dashboard.close')}}
                                        </button>
                                        <input type="submit" id="submit-realtime-video"
                                               value="{{ trans('dashboard.upload') }}" class="btn btn-primary disabled"
                                               disabled>
                                    </div>
                                </form>

                                <div id="realtime-progress-container" style="display: none;">
                                    <div class="progress">
                                        <div id="realtime-progress"
                                             class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 0%"></div>
                                    </div>
                                    <p id="uploading-realtime-text-container"
                                       class="text-center"> {{trans('dashboard.uploading')}}
                                        <span id="realtime-upload-text"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif
        <!---Modal 3 create project--->
            <div class="modal fade" id="create-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content el-16dp">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('dashboard.add_project')}}</h5>
                            <button type="button" class="modal-close" data-dismiss="modal"
                                    aria-label="{{trans('dashboard.close')}}">
                                <span class="fas fa-times"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="newproject-complete" class="alert alert-success" role="alert" aria-atomic="true"
                                 style="display:none;">
                                {{trans('dashboard.project_created')}}
                            </div>
                            <div id="newproject-notcomplete" class="alert alert-danger" role="alert" aria-atomic="true"
                                 style="display:none;">
                                {{trans('dashboard.err_creating_project')}}
                            </div>
                            <div id="newproject-creating" class="alert alert-warning" role="alert" aria-atomic="true"
                                 style="display:none;">
                                {{trans('dashboard.creating_project')}}
                            </div>
                            <form method="POST" action="{{ route('system.newProject') }}" enctype="multipart/form-data"
                                  id="project-form">
                                @csrf
                                @isset($project)
                                    @if(Request::segment(2) == "project")
                                        <input type="hidden" name="father_id" value="{{ $project->id }}">
                                    @endif
                                @endisset
                                <label for="project_name">{{trans('dashboard.project_name')}}</label>
                                <input type="text" class="form-control input-color" id="project_name"
                                       name="project_name" placeholder="{{trans('dashboard.name')}}" required>

                                <div class="modal-footer mt-3">
                                    <button type="button" id="close-project" class="btn btn-secondary"
                                            data-dismiss="modal">
                                        {{trans('dashboard.close')}}
                                    </button>
                                    <input type="submit" value="{{ trans('dashboard.create') }}"
                                           class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <main id="main">
                @yield('content')
            </main>
        </div>
    </div>
@endsection

@section('footer-class', 'fixed-bottom')

@section('scripts')
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src="{{asset('js/vendor/videojs.record.min.js')}}"></script>
    <script src="{{asset('js/vendor/videojs.record.ts-ebml.min.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                $('.sidebarCollapse').on('click', function () {
                    $('.sidebar, #main').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
                $('.sidebar').scrollbar();

                $('#create-project').on('click', function () {
                    $('#create-project-modal').modal('show');
                });

                $('#realtime-video').on('click', function () {
                    $('#realtime-video-modal').modal({backdrop: 'static', keyboard: false});
                    $('#close-realtime').prop('disabled', false);
                });

                $('#upload-video').on('click', function () {
                    $('#upload-video-modal').modal({backdrop: 'static', keyboard: false});
                });

                $('#customVideo').on('change', function () {
                    $('#customVideoLabel').text($('#customVideo').val().replace(/C:\\fakepath\\/i, ''));
                    $('#duration-fps-collapse-menu').collapse('show');
                });

                $('#video-form').on('submit', function (event) {
                    event.preventDefault();
                    let bar = $("#progress");
                    let container = $("#progress-container");
                    let text = $("#upload-text");
                    let form = $('#video-form');
                    let video = $('#customVideo');
                    let alertComplete = $('#video-upload-complete');
                    let alertNotComplete = $('#video-upload-notcomplete');
                    let formDrop = $('#duration-fps-collapse-menu');
                    let videoLabel = $('#customVideoLabel');
                    container.show();
                    form.hide();
                    alertComplete.hide();
                    alertNotComplete.hide();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        xhr: function () {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    let percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                                    bar.attr('aria-valuenow', percentComplete);
                                    bar.width(percentComplete + '%');
                                    text.text(percentComplete + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            let ans = JSON.parse(data);
                            if (ans['result']) {
                                bar.width('100%');
                                $('#uploading-text-container').text('{{trans('dashboard.analyzing')}}');
                                $('#upload-text').text('');
                                ans['files'].forEach(file => {
                                    EmotionAnalysis.analyzeVideo(file['url'], function (report) {
                                        $.post("{{route('system.video.report.set')}}", {
                                            '_method': 'PUT',
                                            '_token': '{{csrf_token()}}',
                                            'report': report,
                                            "video_id": file['id'],
                                        })
                                            .done(function (data) {
                                                if (JSON.parse(data)['done']) {
                                                    alertComplete.show();
                                                } else {
                                                    alertNotComplete.show();
                                                }
                                            })
                                            .fail(function () {
                                                alertNotComplete.show();
                                            })
                                            .always(function () {
                                                container.hide();
                                                form.show();
                                            });
                                    }, {sec_step: 1 / parseFloat($('#framerate-video').val())});
                                });


                                $('#upload-video-modal').on('hidden.bs.modal', function () {
                                    location.reload();
                                });
                            } else {
                                alertNotComplete.show();
                            }

                            video.val('');
                            videoLabel.text('{{trans('dashboard.choose_file')}}');
                            formDrop.collapse('hide');
                        },
                        error: function (data) {
                            container.hide();
                            alertNotComplete.show();
                            console.log(data);

                            video.val('');
                            videoLabel.text('{{trans('dashboard.choose_file')}}');
                            formDrop.collapse('hide');
                            form.show();
                        }
                    });
                });

                $('#project-form').on('submit', function (event) {
                    event.preventDefault();
                    let alertComplete = $('#newproject-complete');
                    let alertNotComplete = $('#newproject-notcomplete');
                    let creating = $('#newproject-creating');
                    let form = $('#project-form');
                    form.hide();
                    alertComplete.hide();
                    alertNotComplete.hide();
                    creating.show();
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            creating.hide();
                            alertComplete.show();
                            $('#project_name').val('');
                            $('#create-project-modal').on('hidden.bs.modal', function () {
                                location.reload();
                            });
                            form.show();
                        },
                        error: function (data) {
                            creating.hide();
                            alertNotComplete.show();
                            console.log(data);
                            form.show();
                        }
                    });
                });

                let VIDEO_DATA, DURATION;
                $('#realtimevideo-form').on('submit', function (event) {
                    event.preventDefault();
                    btnUpload.prop('disabled', true);
                    btnUpload.attr('disabled');
                    btnUpload.hide();
                    let bar = $("#realtime-progress");
                    let container = $("#realtime-progress-container");
                    let text = $("#realtime-upload-text");
                    let form = $('#realtimevideo-form');
                    let video = $('#realtimevideo-file');
                    let alertComplete = $('#realtimevideo-upload-complete');
                    let alertNotComplete = $('#realtimevideo-upload-notcomplete');
                    let formDrop = $('#title-fps-menu');
                    container.show();
                    form.hide();
                    alertComplete.hide();
                    alertNotComplete.hide();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    let formData = new FormData(this);
                    formData.set('video', VIDEO_DATA);
                    formData.set('_token', '{{csrf_token()}}');
                    console.log('FORM DATA');
                    for (var pair of formData.entries()) {
                        console.log(pair[0] + ', ' + pair[1]);
                    }
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        xhr: function () {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    let percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                                    bar.attr('aria-valuenow', percentComplete);
                                    bar.width(percentComplete + '%');
                                    text.text(percentComplete + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            console.log(data);
                            let ans = JSON.parse(data);
                            if (ans['result']) {
                                bar.width('100%');
                                $('#uploading-realtime-text-container').text('{{trans('dashboard.analyzing')}}');
                                ans['files'].forEach(file => {
                                    EmotionAnalysis.analyzeVideo(file['url'], function (report) {
                                        $.post("{{route('system.video.report.set')}}", {
                                            '_method': 'PUT',
                                            '_token': '{{csrf_token()}}',
                                            'report': report,
                                            "video_id": file['id'],
                                        })
                                            .done(function (data) {
                                                if (JSON.parse(data)['done']) {
                                                    alertComplete.show();
                                                    location.reload();
                                                } else {
                                                    alertNotComplete.show();
                                                }
                                            })
                                            .fail(function () {
                                                alertNotComplete.show();
                                            })
                                            .always(function () {
                                                container.hide();
                                                form.hide();
                                            });
                                    }, {sec_step: 1 / parseFloat($('#framerate-realtime').val())});
                                });
                            }
                        },
                        error: function (data) {
                            container.hide();
                            alertNotComplete.show();
                            console.log(data);

                            video.val('');
                            formDrop.collapse('hide');
                            form.show();
                        }
                    });
                });


                let player;

                $('#realtime-video-modal').on('hidden.bs.modal', function () {
                    console.log('hey');
                    // stopStreamedVideo(document.querySelector('video'));
                    $('#vid1').show();
                    $('#title-fps-menu').hide();
                    $('#realtime-body').show();
                    $('#realtime-submit-close').hide();
                    $('#realtimevideo-upload-notcomplete').hide();
                    player.record().stopDevice();
                    player.record().reset();
                });


                //REALTIME VIDEO FUNCTIONS
                let btnNext = $('#next-realtime');
                let btnUpload = $('#submit-realtime-video');

                $('#realtime-video').on('click', function () {
                    player = videojs('vid1', {
                        controls: true,
                        width: 400,
                        height: 250,
                        fluid: true,
                        plugins: {
                            record: {
                                debug: false,
                                audio: true,
                                video: {
                                    width: 1080,
                                    height: 720
                                },
                                frameWidth: 1080,
                                frameHeight: 720,
                                maxLength: Infinity,
                                convertEngine: 'ts-ebml'
                            }
                        }
                    }, function () {
                        videojs.log(
                            'Using video.js', videojs.VERSION,
                            'with videojs-record', videojs.getPluginVersion('record'),
                            'and recordrtc', RecordRTC.version
                        );
                    });

                    // error handling for getUserMedia
                    player.on('deviceError', function () {
                        console.log('device error:', player.deviceErrorCode);
                    });
                    // Handle error events of the video player
                    player.on('error', function (error) {
                        console.log('error:', error);
                    });

                    // user clicked the record button and started recording !
                    player.on('startRecord', function () {
                        $('#close-realtime').prop('disabled',true);
                        console.log('started recording! Do whatever you need to');
                    });

                    // user completed recording and stream is available
                    // Upload the Blob to your server or download it locally !
                    player.on('finishConvert', function () {

                        // the blob object contains the recorded data that
                        // can be downloaded by the user, stored on server etc.
                        console.log('finished recording: ', player.convertedData);
                        btnNext.prop('disabled', false);
                        btnNext.text('{{ trans('dashboard.next') }}');

                        VIDEO_DATA = player.convertedData;
                        DURATION = player.duration;
                    });
                });

                function stopStreamedVideo(videoElem) {
                    const stream = videoElem.srcObject;
                    const tracks = stream.getTracks();

                    tracks.forEach(function (track) {
                        track.stop();
                    });

                    videoElem.srcObject = null;
                }

                $('#next-realtime').on('click', function () {
                    $('#realtime-body').hide();
                    btnUpload.show();
                    $('#realtime-submit-close').show();
                    $('#title-fps-menu').show();
                    // stopStreamedVideo(document.querySelector('video'));
                });

                $('#framerate-realtime').on('input', function () {
                    $('#realtime-framerate-text').text("{{trans('dashboard.framerate')}}: " + $('#framerate-realtime').val());
                });

                $('#framerate-video').on('input', function () {
                    $('#framerate-video-text').text("{{trans('dashboard.framerate')}}: " + $('#framerate-video').val());
                });

                $('#title').change(function () {
                    btnUpload.prop('disabled', false);
                    btnUpload.removeClass('disabled');
                });
            });
        })(jQuery);
    </script>
@endsection
