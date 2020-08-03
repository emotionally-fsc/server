@extends('layouts.sidebar')

@section('title', trans('errors.error') . ' 403')

@section('content')
    <div class="text-center my-5">
        <header class="mb-4">
            <h1>
                <span class="display-1 d-block far fa-sad-cry mb-2" aria-hidden="true"></span>
                {{strtoupper(trans('errors.error'))}}: 403
            </h1>
            <p class="lead">@lang('errors.forbidden_access')</p>
        </header>
        <p>@lang('errors.forbidden_access_message')<br/>
            {!!
                trans('errors.suggestion', [
                    'first_option'=>'<button onclick="window.history.back();" class="btn p-0 btn-link border-0 align-baseline">'.trans('errors.go_back').'</button>',
                    'second_option'=>'<a href="'.route('system.home').'">'.trans('errors.return_home').'</a>'
                ])
            !!}
        </p>
    </div>
@endsection
