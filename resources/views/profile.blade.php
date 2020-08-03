@extends('layouts.system')

@section('title', trans('dashboard.profile'))

@section('inner-content')
    <div class="row">
        <div class="col-12">
            <div id="profile-changed" class="alert alert-success" role="alert" aria-atomic="true"
                 style="display:none;">
                {{trans('dashboard.profile-changed')}}
            </div>
            <div id="profile-not-changed" class="alert alert-danger" role="alert" aria-atomic="true"
                 style="display:none;">
                {{trans('dashboard.err-changing-profile')}}
            </div>
            <div id="profile-changing" class="alert alert-warning" role="alert" aria-atomic="true"
                 style="display:none;">
                {{trans('dashboard.profile-changing')}}
            </div>
            <form method="POST" action="{{ route('system.edit-profile') }}"
                  id="edit-profile-form" novalidate>
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">@lang('auth.name')*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                    <span
                                        class="input-group-text input-color @error('name') border border-danger @enderror"
                                        id="name-icon">
                                        <em class="fas fa-user" style="padding: 0 2px;"></em>
                                    </span>
                            </div>
                            <input type="text" class="form-control input-color" id="name"
                                   name="name" value="{{Auth::user()->name}}" placeholder="@lang('auth.name')" required>
                        </div>
                        @error('name')<p class="text-center text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="surname">@lang('auth.surname')*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('surname') border border-danger @enderror"
                              id="surname-icon"><em class="fas fa-user" style="padding: 0 2px;"></em></span>
                            </div>
                            <input type="text" class="form-control input-color" id="surname"
                                   name="surname" value="{{Auth::user()->surname}}"
                                   placeholder="@lang('auth.surname')" required>
                        </div>
                        @error('surname')<p class="text-center text-danger">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="old-password">{{trans('dashboard.old-password')}}*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('password') border border-danger @enderror"
                              id="password-confirm-icon"><em class="fas fa-lock" style="padding: 0 2px;"></em></span>
                        </div>
                        <input type="password" class="form-control input-color" id="old-password"
                               name="old_password" value="" placeholder="{{trans('dashboard.old-password')}}"
                               required>
                    </div>
                    <div class="invalid-feedback" id="wrong-old-password">@lang('auth.old-password-wrong')</div>
                </div>
                <div class="form-group">
                    <label for="password">{{trans('dashboard.newpassword')}}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('password') border border-danger @enderror"
                              id="password-confirm-icon"><em class="fas fa-lock" style="padding: 0 2px;"></em></span>
                        </div>
                        <input type="password" class="form-control input-color" id="password"
                               name="password" placeholder="{{trans('dashboard.newpassword')}}">
                    </div>
                    @error('password')<p class="text-center text-danger">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="confirm-password">{{trans('dashboard.confirm-password')}}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('password') border border-danger @enderror"
                              id="password-confirm-icon"><em class="fas fa-lock" style="padding: 0 2px;"></em></span>
                        </div>
                        <input type="password" class="form-control input-color" id="confirm-password"
                               name="confirm_password" placeholder="{{trans('dashboard.confirm-password')}}">
                    </div>
                    @error('password')<p class="text-center text-danger">{{ $message }}</p>@enderror
                    <div class="invalid-feedback" id="wrong-new-password">@lang('auth.passwords-not-equal')</div>
                </div>
                <div class="form-row mt-4 text-center">
                    <div class="form-group col-12 col-md-6 pr-2">
                        <button type="reset" id="close-edit-profile" class="btn btn-md-text">
                            {{trans('dashboard.reset')}}
                        </button>
                    </div>
                    <div class="form-group col-12 col-md-6 pl-2">
                        <button type="submit" id="submit-edit-profile" class="btn btn-outline-primary text-uppercase">
                            {{trans('dashboard.save')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#side-home-btn').removeClass('active');
                $('#side-profile-btn').addClass('active');

                (function () {
                    'use strict';
                    window.addEventListener('load', function () {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        let forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        Array.prototype.filter.call(forms, function (form) {
                            form.addEventListener('submit', function (event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();

                $('#password, #confirm-password').on('change', function () {
                    let valid = checkPassword();
                    $('#wrong-new-password').toggle(!valid);
                    $('#submit-edit-profile').prop('disabled', !valid);
                });

                $('#old-password').on('change', function () {
                    $('#wrong-old-password').hide();
                });

                function checkPassword() {
                    let newPass = $('#password').val();
                    let confirmPass = $('#confirm-password').val();

                    return newPass === confirmPass;
                }

                $('#edit-profile-form').on('submit', function (event) {
                    if (checkPassword()) {
                        event.preventDefault();
                        let alertComplete = $('#profile-changed');
                        let alertNotComplete = $('#profile-not-changed');
                        let creating = $('#profile-changing');
                        let form = $('#edit-profile-form');
                        form.hide();
                        alertComplete.hide();
                        alertNotComplete.hide();
                        creating.show();
                        $.post('{{route('system.user.password.check')}}', {
                            '_token': '{{csrf_token()}}',
                            'old_password': $('#old-password').val()
                        })
                            .done(function (data) {
                                data = JSON.parse(data);
                                if (data['done']) {
                                    let formData = new FormData($('#edit-profile-form')[0]);
                                    $.ajax({
                                        url: $('#edit-profile-form')[0].action,
                                        type: $('#edit-profile-form')[0].method,
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function (data) {
                                            creating.hide();
                                            alertComplete.show();
                                            $('#user-profile-name-surname').text($('#name').val() + ' ' + $('#surname').val());
                                            setTimeout(() => {
                                                $('#password').val('');
                                                $('#confirm-password').val('');
                                                $('#old-password').val('');
                                                form.show();
                                            })
                                        },
                                        error: function (data) {
                                            // ERRORI NELLA CONNESIONE AL SERVER
                                            creating.hide();
                                            alertNotComplete.show();
                                            alertNotComplete.show();
                                            console.error(data);
                                            form.show();
                                        }
                                    });
                                } else {
                                    if (!data.hasOwnProperty('errors')) {
                                        $('#wrong-old-password').show();
                                    } else {
                                        // ERRORI NELLA RICHIESTA
                                        console.error(data['errors']);
                                    }
                                    creating.hide();
                                    alertNotComplete.show();
                                    console.log(data);
                                    form.show();
                                }
                            })
                            .fail(function (data) {
                                creating.hide();
                                alertNotComplete.show();
                                console.log(data);
                                form.show();
                            });

                    } else {
                        $('.invalid-feedback').show();
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
