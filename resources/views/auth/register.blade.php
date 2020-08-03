@extends('auth.style')

@section('title')
    @lang('auth.sign-up')
    @endsection

@section('form-name')
    @lang('auth.sign-up')
@endsection

@section('form')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">@lang('auth.name')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('name') border border-danger @enderror"
                              id="name-icon"><em class="fas fa-user" style="padding: 0 2px;"></em></span>
                    </div>
                    <input type="text" class="form-control input-color @error('name') border border-danger @enderror"
                           id="name" name="name" autocomplete="name"
                           value="{{ old('name') }}" placeholder="@lang('auth.name')" required>
                </div>
                @error('name')<p class="text-center text-danger">{{ $message }}</p>@enderror
            </div>
            <div class="form-group col-md-6">
                <label for="surname">@lang('auth.surname')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('surname') border border-danger @enderror"
                              id="surname-icon"><em class="fas fa-user" style="padding: 0 2px;"></em></span>
                    </div>
                    <input type="text" class="form-control input-color @error('surname') border border-danger @enderror"
                           id="surname" name="surname" autocomplete="surname"
                           value="{{ old('surname') }}" placeholder="@lang('auth.surname')" required>
                </div>
                @error('surname')<p class="text-center text-danger">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('email') border border-danger @enderror"
                              id="email-icon"><em class="fas fa-envelope" style="padding: 0 2px;"></em></span>
                </div>
                <input type="email" class="form-control input-color @error('email') border border-danger @enderror"
                       id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                       value="{{ old('email') }}" placeholder="email@email.com" required>
            </div>
            @error('email')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('password') border border-danger @enderror"
                              id="password-icon"><em class="fas fa-lock" style="padding: 0 2px;"></em></span>
                </div>
                <input type="password"
                       class="form-control input-color @error('password') border border-danger @enderror" id="password"
                       name="password" autocomplete="new-password"
                       placeholder="••••••••" required>
            </div>
        </div>
        <div class="form-group">
            <label for="password-confirm">@lang('auth.password-confirm')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('password') border border-danger @enderror"
                              id="password-confirm-icon"><em class="fas fa-lock" style="padding: 0 2px;"></em></span>
                </div>
                <input type="password"
                       class="form-control input-color @error('password') border border-danger @enderror"
                       id="password-confirm"
                       name="password_confirmation" autocomplete="new-password"
                       placeholder="••••••••" required>
            </div>
            @error('password')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-outline-primary w-100">@lang('auth.sign-up')</button>
    </form>
    <p id="login" class="text-center mt-3">@lang('auth.ext-user') <a
            href="{{ route('login') }}">@lang('auth.login')</a></p>
@endsection

@section('scripts')
    @parent
@endsection
