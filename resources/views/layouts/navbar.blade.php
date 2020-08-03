@extends('layouts.master')

@section('head')
    <style>
        body {
            padding-top: 56px; /* Padding for the navbar */
        }
    </style>
@endsection

@section('body-attr')
    data-spy="scroll" data-target="#main-navigation" data-offset="100" style="position: relative;"
@endsection

@section('body')
    <header>
        <nav id="main-navigation" class="navbar navbar-expand-lg navbar-dark el-8dp fixed-top"
             aria-label="Main navigation">
            <div class="container">
                <a class="navbar-brand" style="text-decoration: none;" href="#">
                    <img src="{{asset('/logo.png')}}" width="30"
                         height="30"
                         class="d-inline-block align-top" alt="Emotionally's logo">
                    <img src="{{asset('/app_name.svg')}}" width="150"
                         height="30"
                         class="d-inline-block align-tp" alt="Emotionally">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#main-navigation-content"
                        aria-controls="main-navigation-content" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-navigation-content">
                    @yield('navbar-content')
                </div>
            </div>
        </nav>
    </header>

    <main class="content" id="main">
        @yield('content')
    </main>
@endsection

@section('footer')
    <div class="footer-content py-3 el-4dp">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 text-md-left text-center">
                    <h5 class="mb-3 mt-3 mt-md-1">@lang('navbar.title_emotionally')</h5>
                    <p>@lang('navbar.description_emotionally')</p>
                </div>
                <div class="col-12 col-md-4 text-md-center text-center">
                    <h5 class="mb-3 mt-3 mt-md-1">@lang('navbar.title_information')</h5>
                    <p>@lang('navbar.description_information')</p>
                </div>
                <div class="col-12 col-md-4 text-md-right text-center">
                    <h5 class="mb-3 mt-3 mt-md-1">@lang('navbar.title_other_link')</h5>
                    <p>
                        <a href="https://f-s-c.github.io/" rel="noopener noreferrer" target="_blank">FSC</a><br>
                        <a href="https://strumentalmente.it/" rel="noopener noreferrer"
                           target="_blank">Strumentalmente</a><br>
                        <a href="https://github.com/F-S-C/Cicerone" rel="noopener noreferrer" target="_blank">Repository
                            Cicerone</a> <br>
                        <a href="https://github.com/F-S-C/Emotionally" rel="noopener noreferrer" target="_blank">Repository
                            Emotionally</a><br>
                        <a href="https://github.com/F-S-C/StrumentalMente" rel="noopener noreferrer" target="_blank">Repository
                            Strumentalmente</a><br>
                        <a href="https://github.com/F-S-C/The-Doomed-Ship" rel="noopener noreferrer" target="_blank">The
                            Doomed Ship</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @parent
@endsection
