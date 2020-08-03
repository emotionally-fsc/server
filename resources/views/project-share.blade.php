@extends('layouts.system')

@section('title', $project->name . ': Share & Permissions')

@section('head')
    <style>
        .input-color {
            background-color: #232323 !important;
            color: white !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }
    </style>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('system.home')}}">
            <span class="fas fa-home" aria-hidden="true"></span>
            @lang('dashboard.home')
        </a>
    </li>
    @foreach($path as $father)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            <a href="{{route('system.project-details', $father->id)}}">
                <span class="fas fa-folder" aria-hidden="true"></span>
                {{$father->name}}
            </a>
        </li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page">
        <span class="fas fa-share-alt" aria-hidden="true"></span>
        {{trans('project-share.share-permission')}}
    </li>
@endsection

@section('inner-content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <details class="card el-1dp p-3 rounded">
        <summary>{{trans('project-share.share-project')}}</summary>
        <div class="card-body">
            <p>{{trans('project-share.fill-form')}}</p>
            <form id="share-form" method="post"
                  action="{{route('system.permissions.add', $project->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group mr-sm-3">
                    <label for="email-input">{{trans('project-share.email')}}</label>
                    <input class="form-control input-color @error('email') border border-danger @enderror" name="email"
                           id="email-input" type="email"
                           placeholder="email@provider.com" required>
                </div>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="read-input" value="true" checked disabled>
                        <label class="form-check-label" for="read-input">{{trans('project-share.can-read')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="modify-input" value="true" name="modify">
                        <label class="form-check-label" for="modify-input">{{trans('project-share.can-edit')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="add-input" value="true" name="add">
                        <label class="form-check-label" for="add-input">{{trans('project-share.can-add')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="remove-input" value="true" name="remove">
                        <label class="form-check-label" for="remove-input">{{trans('project-share.can-remove')}}</label>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" id="add-new-permission">
                    <span class="fas fa-plus-circle mr-1" aria-hidden="true"></span>
                    {{trans('project-share.add')}}
                </button>
            </form>
        </div>
    </details>
    <div class="table-responsive mt-3">
        <table id="permissions-table" class="display w-100 table table-striped table-borderless">
            <caption class="sr-only">{{trans('project-share.users-with-project')}}</caption>
            <thead class="text-uppercase">
            <tr>
                <th scope="col">{{trans('project-share.name')}}</th>
                <th scope="col">{{trans('project-share.email')}}</th>
                <th scope="col" class="text-center">{{trans('project-share.can-read')}}</th>
                <th scope="col" class="text-center">{{trans('project-share.can-edit')}}</th>
                <th scope="col" class="text-center">{{trans('project-share.can-add')}}</th>
                <th scope="col" class="text-center">{{trans('project-share.can-remove')}}</th>
                <th scope="col"><span class="sr-only">{{trans('project-share.delete')}}</span></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($project->users))
                @foreach($project->users as $user)
                    <tr data-href="{{route('system.project-details', $user->id)}}">
                        <td class="align-middle">{{$user->name}} {{$user->surname}}</td>
                        <td class="align-middle">{{$user->email}}</td>
                        <td class="text-center align-middle">@include('partials.yes-no', ['ans'=> $user->pivot->read])</td>
                        <td class="text-center align-middle">
                            <button class="edit-permissions-button btn btn-md-text-white" data-permission="modify"
                                    data-user="{{$user->id}}"
                                    data-value="{{$user->pivot->modify}}">
                                @include('partials.yes-no', ['ans'=> $user->pivot->modify])
                            </button>
                        </td>
                        <td class="text-center align-middle">
                            <button class="edit-permissions-button btn btn-md-text-white" data-permission="add"
                                    data-user="{{$user->id}}"
                                    data-value="{{$user->pivot->add}}">
                                @include('partials.yes-no', ['ans'=> $user->pivot->add])
                            </button>
                        </td>
                        <td class="text-center align-middle">
                            <button class="edit-permissions-button btn btn-md-text-white" data-permission="remove"
                                    data-user="{{$user->id}}"
                                    data-value="{{$user->pivot->remove}}">
                                @include('partials.yes-no', ['ans'=> $user->pivot->remove])
                            </button>
                        </td>
                        <td class="text-center align-middle">
                            <form method="post"
                                  action="{{route('system.permissions.delete', [$project->id, $user->id])}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-md-text-danger" type="submit"
                                        onclick="return confirm('Do you really want to revoke all permissions for {{ $user->email  }}?');">
                                    {{trans('project-share.delete')}}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        (function ($) {
            $(document).ready(function () {
                let table = $('#permissions-table').DataTable({
                    "order": [[0, "asc"]],
                    "paging": false,
                    "info": false,
                    "columnDefs": [
                        {
                            "targets": 6,
                            "orderable": false
                        },
                    ],
                    "dom": '<"top"i>rt<"bottom"><"clear">',
                });


                $('#search-bar').on('keydown click change paste mouseup', function () {
                    table.search($('#search-bar').val()).draw();
                });

                $('#share-form input:checkbox').change(function () {
                    $('#add-new-permission').prop('disabled', $('#share-form input:checkbox:checked').length === 0);
                    let canReadInput = $('#read-input');
                });

                $('button.edit-permissions-button').click(function () {
                    const yesIcon = `@include('partials.yes-no', ['ans'=>true])`;
                    const noIcon = `@include('partials.yes-no', ['ans'=>false])`;

                    console.log($(this).data('value'));

                    let newPermission = $(this).data('value') === 0;
                    $(this).html(newPermission ? yesIcon : noIcon);
                    $(this).data('value', newPermission ? 1 : 0);

                    $.post('{{route('system.permissions.edit', $project->id)}}',
                        {
                            '_token': '{{csrf_token()}}',
                            'user_id': $(this).data('user'),
                            'permission': $(this).data('permission'),
                            'value': newPermission
                        })
                        .done(function (data) {
                            console.log(data);

                        })
                        .fail(function (data) {
                            console.log(data);
                        });
                });
            });
        })(jQuery);
    </script>
@endsection
