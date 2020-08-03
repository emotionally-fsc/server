@extends('auth.style')

@section('title','Login')

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

        #go:hover {
            border: none;
        }
    </style>
@endsection

@section('form-name')
    @lang('auth.login')
@endsection

@section('form')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        @error('email')<p class="text-center text-danger">@lang('auth.bad-login')</p>@enderror
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text input-color @error('email') border border-danger @enderror"
                          id="email-icon"><em class="fas fa-envelope" style="padding: 0 1px;"></em></span>
                </div>
                <input type="email" class="form-control input-color @error('email') border border-danger @enderror"
                       id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                       value="{{ old('email') }}" placeholder="email@email.com" required>
                <div class="input-group-append">
                    <span class="input-group-text input-color @error('email') border border-danger @enderror"><a id="go"
                                                                                                                 href="#"><em
                                class="fas fa-arrow-right" style="padding: 0 1px;"></em></a></span>
                </div>
            </div>
        </div>
        <div id="second-part" class="m-fadeOut">
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('email') border border-danger @enderror"
                              id="password-icon"><em class="fas fa-lock" style="padding: 0 2px;"></em></span>
                    </div>
                    <input type="password"
                           class="form-control input-color @error('email') border border-danger @enderror" id="password"
                           name="password" aria-describedby="password-icon" autocomplete="current-password"
                           placeholder="••••••••" required>
                </div>
            </div>
            <div class="custom-control custom-switch pb-3">
                <input type="checkbox" class="custom-control-input" name="remember"
                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">@lang('auth.remember')</label>
            </div>
            <button type="submit" class="btn btn-outline-primary w-100">@lang('auth.login')</button>
        </div>
    </form>
    <p class="text-center mt-3">@lang('auth.new-user') <a
            href="{{ route('register') }}">@lang('auth.sign-up')</a></p>
    <p class="text-center mt-3"><a
            href="{{ route('password.request') }}">@lang('auth.forgot-password')</a></p>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            @if($errors->has('email'))
            $("#second-part").removeClass('m-fadeOut').addClass('m-fadeIn');
            $("#go").removeAttr('href').attr('style', 'color:grey;');
            @else
            $("#go").click(function () {
                $("#second-part").removeClass('m-fadeOut').addClass('m-fadeIn');
                $("#go").removeAttr('href').attr('style', 'color:grey;');
            });
            $(document).keypress(function (e) {
                var go = $("#go");
                var attr = go.attr('href');
                if (e.which === 13) {
                    if (typeof attr !== typeof undefined && attr !== false) {
                        go.click();
                    }
                }
            });
            @endif
        });
    </script>
@endsection
