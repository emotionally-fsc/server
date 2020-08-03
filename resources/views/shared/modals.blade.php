<style>
    .input-color {
        background-color: #232323 !important;
        color: white !important;
    }

    .modal-close {
        color: white !important;
        background-color: transparent;
        border: none;
    }

    .modal-close:hover {
        color: rgba(255, 255, 255, 0.5) !important;
    }


</style>

<!-- Modal rinomina progetto -->
<div class="modal fade" id="rename-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('dashboard.rename-project')}}</h5>
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('system.rename-project') }}"
                      id="project-rename-form">
                    @csrf
                    <input type="hidden" id="project_rename_id" name="project_rename_id">
                    <label for="project_new_name">{{trans('dashboard.project_name')}}</label>
                    <input type="text" class="form-control input-color" id="project_new_name"
                           name="project_name" placeholder="{{trans('dashboard.name')}}" required>

                    <div class="modal-footer mt-3">
                        <button type="button" id="close-rename-project" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.close')}}
                        </button>
                        <input type="submit" value="{{ trans('dashboard.rename') }}" class="btn btn-primary">
                    </div>
                </form>
                <div id="project-rename-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="project-rename-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="project-rename-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal elimina progetto -->
<div class="modal fade" id="delete-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('dashboard.delete-project')}}</h5>
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('system.delete-project') }}"
                      id="project-delete-form">
                    @csrf
                    <input type="hidden" id="project_delete_id" name="project_delete_id">
                    <p>{{trans('dashboard.confirm-remove.project')}}</p>
                    <div class="modal-footer mt-3">
                        <button id="close-delete-project" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.no')}}
                        </button>
                        <input type="submit" id="submit-delete-project" class="btn btn-primary"
                               data-dismiss="modal" value="{{trans('dashboard.yes')}}">
                    </div>
                </form>
                <div id="project-delete-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="project-delete-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="project-delete-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal rinomina video -->
<div class="modal fade" id="rename-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('dashboard.rename-video')}}</h5>
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('system.rename-video') }}"
                      id="video-rename-form">
                    @csrf
                    <input type="hidden" id="video_rename_id" name="video_rename_id">
                    <label for="video_new_name">{{trans('dashboard.video_rename')}}</label>
                    <input type="text" class="form-control input-color" id="video_new_name"
                           name="video_name" placeholder="{{trans('dashboard.name')}}" required>

                    <div class="modal-footer mt-3">
                        <button type="button" id="close-rename-video" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.close')}}
                        </button>
                        <input type="submit" value="{{ trans('dashboard.rename') }}" class="btn btn-primary">
                    </div>
                </form>
                <div id="video-rename-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="video-rename-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="video-rename-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal elimina video -->
<div class="modal fade" id="delete-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('dashboard.delete-video')}}</h5>
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('system.delete-video') }}"
                      id="video-delete-form">
                    @csrf
                    <input type="hidden" id="video_delete_id" name="video_delete_id">
                    <p>{{trans('dashboard.confirm-delete-video')}}</p>
                    <div class="modal-footer mt-3">
                        <button id="close-delete-video" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.no')}}
                        </button>
                        <input type="submit" id="submit-delete-video" class="btn btn-primary"
                               data-dismiss="modal" value="{{trans('dashboard.yes')}}">
                    </div>
                </form>
                <div id="video-delete-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="video-delete-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="video-delete-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal sposta progetto -->
<div class="modal fade" id="move-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('dashboard.move-project')}}</h5>
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="project-move-tree" class="container-fluid">
                    <p class="text-left">{{trans('dashboard.select-destination')}}</p>
                    <button class="btn btn-outline-primary btn-list-project" onclick="selectProject(this,'')"><span
                            class="fas fa-home mr-1"></span>{{trans('dashboard.root')}}</button>
                    <ul class="ml-3 list-unstyled" id="pr_list">
                        @each('partials.project-tree', Auth::user()->projects->where('father_id', null), 'main_project')
                    </ul>
                </div>
                <form method="POST" action="{{ route('system.move-project') }}"
                      id="project-move-form">
                    @csrf
                    <input type="hidden" id="project_selected_id" name="project_selected_id">
                    <input type="hidden" id="project_destination_id" name="project_destination_id">
                    <div class="modal-footer mt-3">
                        <button id="close-move-project" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.no')}}
                        </button>
                        <input type="submit" id="submit-move-project" class="btn btn-primary disabled"
                               data-dismiss="modal" value="{{trans('dashboard.move')}}" disabled>
                    </div>
                </form>
                <div id="project-move-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="project-move-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="project-move-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal sposta video -->
<div class="modal fade" id="move-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('dashboard.move-video')}}</h5>
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="video-move-tree" class="container-fluid">
                    <p class="text-left">{{trans('dashboard.select-destination')}}</p>
                    <ul class="ml-3 list-unstyled">
                        @each('partials.video_project-tree', Auth::user()->projects->where('father_id', null), 'main_project')
                    </ul>
                </div>
                <form method="POST" action="{{ route('system.move-video') }}"
                      id="video-move-form">
                    @csrf
                    <input type="hidden" id="video_selected_id" name="video_selected_id">
                    <input type="hidden" id="video_project_destination_id" name="video_project_destination_id">
                    <div class="modal-footer mt-3">
                        <button id="close-move-video" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.no')}}
                        </button>
                        <input type="submit" id="submit-move-video" class="btn btn-primary disabled"
                               data-dismiss="modal" value="{{trans('dashboard.move')}}" disabled>
                    </div>
                </form>
                <div id="video-move-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="video-move-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="video-move-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>


