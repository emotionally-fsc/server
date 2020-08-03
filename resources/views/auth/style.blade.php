@extends('layouts.master')

@section('head')
    @parent
    <style>
        html,
        body {
            height: 100%;
            background-image: url("{{ asset('/people.jpg') }}");
            background-repeat: no-repeat;
            background-position: center;
        }

        .input-color {
            background-color: #232323 !important;
            color: white !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }

        .w-small{
            width: 60%!important;
        }

        @media only screen and (max-width: 600px) {
            .w-small {
                width: 100%!important;
            }
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid w-small">
    <div class="container mw-100">
        <header class="row">
            <div class="col py-2 my-4">
                <a href="{{ route('landing') }}">
                    <div class="row">
                        <img src="{{ asset('/logo.png') }}" class="mx-auto d-block img-fluid" width="100"
                             alt="Emotionally's Logo">
                    </div>
                    <div class="row">
                        <img src="{{ asset('/app_name.svg') }}" class="mx-auto d-block" width="150" alt="Emotionally">
                    </div>
                </a>
            </div>
        </header>
        <div class="row">
            <main class="col px-md-5 pt-4 pb-3 mb-2 rounded el-2dp shadow" id="main">
                <h1 class="h2 text-center mb-3">@yield('form-name')</h1>
                @yield('form')
            </main>
        </div>
    </div>
    </div>
@endsection

@section('footer')
@endsection
