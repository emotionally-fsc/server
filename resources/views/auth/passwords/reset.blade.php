@extends('auth.style')

@section('title','Reset')

@section('form-name')
    @lang('auth.reset-password')
@endsection

@section('form')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <input type="email" class="form-control input-color @error('email') border border-danger @enderror"
                   id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                   value="{{ $email ?? old('email') }}" placeholder="email@email.com" required>
            @error('email')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password"
                   class="form-control input-color @error('password') border border-danger @enderror" id="password"
                   name="password" autocomplete="new-password"
                   placeholder="••••••••" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">@lang('auth.password-confirm')</label>
            <input type="password"
                   class="form-control input-color @error('password') border border-danger @enderror"
                   id="password-confirm"
                   name="password_confirmation" autocomplete="new-password"
                   placeholder="••••••••" required>
            @error('password')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">@lang('auth.reset-password')</button>
    </form>
    <div class="container py-1">&nbsp;</div>
@endsection

@section('scripts')
    @parent
@endsection
