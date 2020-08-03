@extends('auth.style')

@section('title')
    @lang('auth.verify-email')
@endsection

@section('head')
    @parent
    <style>

        .m-fadeOut {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s linear 300ms, opacity 300ms;
            display: none;
        }

        .m-fadeIn {
            visibility: visible;
            opacity: 1;
            transition: visibility 0s linear 0s, opacity 300ms;
            display: block;
        }
    </style>
@endsection

@section('form-name')
    @lang('auth.verify-email')
@endsection

@section('form')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            @lang('auth.verify-link-sent')
        </div>
    @endif
    <p class="text-center">@lang('auth.before-proceed-verify')</p>
    <br/>
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <p class="text-center">@lang('auth.did-not-receive')
            <button type="submit"
                    class="btn btn-link p-0 m-0 align-baseline">@lang('auth.send-another-mail')</button>
            .
        </p>
    </form>
    <div class="text-center">
        <a class="btn btn-secondary mt-3" href="{{ route('logout') }}">@lang('auth.logout')</a>
    </div>
@endsection

@section('scripts')
    @parent
@endsection
