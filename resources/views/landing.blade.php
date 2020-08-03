@extends('layouts.navbar')

@section('title', 'Landing')

@section('head')
    @parent
    <style>
        .splash-screen {
            text-align: center;
            width: 100%;
            height: calc(100vh - 56px);
            background-color: #FF9800;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .splash-screen .inner {
            position: absolute;
            top: 50%;
            left: 50%;
            box-shadow: 0 0 24px black;
            border-radius: 15px;
            transform: translate(-50%, -50%);
            padding: 24px;
        }

        .splash-screen .inner .logo {
            width: 20vw;
            max-width: 150px;
        }
    </style>
@endsection

@section('navbar-content')
    <ul class="ml-auto navbar-nav">
        <li class="nav-item active">
            <a class="nav-link text-center" href="#landing">{{trans('landing.home')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-center" href="#features">{{trans('landing.features')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-center" href="#about">{{trans('landing.about')}}</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-center" href="#" id="language-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @lang('navbar.language')
            </a>
            <div class="dropdown-menu" aria-labelledby="language-dropdown">
                <a class="dropdown-item text-center" href="{{route('language.set', 'it')}}">@lang('navbar.italian')</a>
                <a class="dropdown-item text-center" href="{{route('language.set', 'en')}}">@lang('navbar.english')</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="btn btn-outline-primary nav-link"
               href="{{ route('login') }}">
                @if (Auth::check())
                    {{ trans('landing.system') }}
                @else
                    {{ trans('landing.login') }}
                @endif</a>
        </li>
    </ul>
@endsection

@section('content')
    @parent

    <section id="landing">
        <div class="splash-screen">
            <div class="inner el-12dp">
                <img class="logo" src="{{asset('/logo.png')}}"
                     alt="Emotionally's Logo">
                <h1 itemprop="name">{{trans('landing.emotionally')}}</h1>
                <p itemprop="headline">{{ trans('metadata.description') }}</p>
                <div style="margin-top: 1rem;">
                    <a class="btn btn-outline-white btn-rounded waves-effect scroll-down" href="#features">
                        <span class="fas fa-chevron-down"></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-5" id="features">
        <h2>@lang('landing.features')</h2>
        <div class="row text-center mt-5">
            <div class="col-12 col-sm-6 col-md-3">
                <span class="fas fa-grin-alt fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features1')</p>
                <p>@lang('landing.descriptionfeatures1')</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <span class="fas fa-file-video fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features2')</p>
                <p>@lang('landing.descriptionfeatures2')</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <span class="fas fa-folder fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features3')</p>
                <p>@lang('landing.descriptionfeatures3')</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <span class="fas fa-file-export fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features4')</p>
                <p>@lang('landing.descriptionfeatures4')</p>
            </div>
        </div>
    </section>
    <section class="container my-5" id="about">
        <h2>@lang('landing.about')</h2>

        <div class="row">
            <div class="col bd-content">
                <section class="team-section text-center my-5" id="team">
                    <div class="row">
                        <div class="col-lg-1 col-md-6">
                            <!-- SPACER -->
                        </div>

                        <div class="col-lg-2 col-md-6 mb-lg-0 mb-5 team-member" itemprop="author">
                            <div class="avatar mx-auto">
                                <img src="https://strumentalmente.github.io/assets/images/team/Alessandro.jpg" width="100%"
                                     class="rounded-circle z-depth-1" alt="Alessandro">
                            </div>
                            <p class="font-weight-bold mt-4 mb-3 h5">
                                <span itemprop="givenName">Alessandro</span><br>
                                <span itemprop="familyName">Annese</span>
                            </p>
                            <ul class="list-inline list-unstyled mb-0">

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer" href="https://github.com/Ax3lFernus"
                                       target="_blank">
                                        <span class="fab fa-github"></span>
                                    </a>
                                </li>

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer"
                                       href="https://www.linkedin.com/in/alessandro-annese-79683913b/" target="_blank">
                                        <span class="fab fa-linkedin"></span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-lg-0 mb-5 team-member" itemprop="author">
                            <div class="avatar mx-auto">
                                <img src="https://strumentalmente.github.io/assets/images/team/Davide.jpg" width="100%"
                                     class="rounded-circle z-depth-1" alt="Davide">
                            </div>
                            <p class="font-weight-bold mt-4 mb-3 h5">
                                <span itemprop="givenName">Davide</span><br>
                                <span itemprop="familyName">De Salvo</span>
                            </p>
                            <ul class="list-inline list-unstyled mb-0">

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer" href="https://github.com/Davidedes"
                                       target="_blank">
                                        <span class="fab fa-github"></span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-lg-0 mb-5 team-member" itemprop="author">
                            <div class="avatar mx-auto">
                                <img src="https://strumentalmente.github.io/assets/images/team/Andrea.jpg" width="100%"
                                     class="rounded-circle z-depth-1" alt="Andrea">
                            </div>
                            <p class="font-weight-bold mt-4 mb-3 h5">
                                <span itemprop="givenName">Andrea</span><br>
                                <span itemprop="familyName">Esposito</span>
                            </p>

                            <ul class="list-inline list-unstyled mb-0">

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer"
                                       href="https://github.com/espositoandrea" target="_blank">
                                        <span class="fab fa-github"></span>
                                    </a>
                                </li>

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer"
                                       href="https://www.linkedin.com/in/andrea-esposito-183bb016b/" target="_blank">
                                        <span class="fab fa-linkedin"></span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-lg-0 mb-5 team-member" itemprop="author">
                            <div class="avatar mx-auto">
                                <img src="https://strumentalmente.github.io/assets/images/team/Graziano.jpg" width="100%"
                                     class="rounded-circle z-depth-1" alt="Graziano">
                            </div>
                            <p class="font-weight-bold mt-4 mb-3 h5">
                                <span itemprop="givenName">Graziano</span><br>
                                <span itemprop="familyName">Montanaro</span>
                            </p>
                            <ul class="list-inline list-unstyled mb-0">

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer" href="https://github.com/prewarning"
                                       target="_blank">
                                        <span class="fab fa-github"></span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-lg-0 mb-5 team-member" itemprop="author">
                            <div class="avatar mx-auto">
                                <img src="https://strumentalmente.github.io/assets/images/team/Regina.jpg" width="100%"
                                     class="rounded-circle z-depth-1" alt="Regina">
                            </div>


                            <p class="font-weight-bold mt-4 mb-3 h5">
                                <span itemprop="givenName">Regina</span><br>
                                <span itemprop="familyName">Zaccaria</span>
                            </p>
                            <ul class="list-inline list-unstyled mb-0">

                                <li class="list-inline-item">
                                    <a class="p-2 fa-lg" rel="noopener noreferrer"
                                       href="https://github.com/ReginaZaccaria" target="_blank">
                                        <span class="fab fa-github"></span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="col-lg-1 col-md-6">
                            <!-- SPACER -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@section("scripts")
    @parent
    <script type="text/javascript" src="{{asset(mix('/js/vendor/affdex.js'))}}"></script>
    <script type="text/javascript" src="{{asset(mix('/js/emotion-analysis.js'))}}"></script>
@endsection
