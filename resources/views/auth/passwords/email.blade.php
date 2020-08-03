@extends('auth.style')

@section('title','Reset')

@section('form-name')
    @lang('auth.reset-password')
@endsection

@section('form')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            @lang('auth.email-reset-sent')
        </div>
    @endif
    <form @if(session('status')) method="GET" action="{{ route('landing') }}" @else method="POST"
          action="{{ route('password.email') }}" @endif>
        @csrf
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <input type="email" class="form-control input-color @error('email') border border-danger @enderror"
                   id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                   value="{{ old('email') }}" placeholder="email@email.com"
                   required @if (session('status')) disabled @endif>
            @error('email')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">@if(session('status')) @lang('auth.go-to-landing') @else @lang('auth.send-reset-link') @endif</button>
    </form>
    @if(session('status'))
        <div class="container py-1">&nbsp;</div>
    @else
        <p id="login" class="text-center mt-3">@lang('auth.change-mind') <a
                href="{{ route('login') }}">@lang('auth.login')</a></p>
    @endif
@endsection

@section('scripts')
    @parent
@endsection
