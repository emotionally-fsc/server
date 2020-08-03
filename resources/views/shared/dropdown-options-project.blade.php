<style>
    .dropleft .dropdown-toggle::before {
        display: none;
    }
</style>
<div class="dropdown more-icon dropleft">
    <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
            type="button" id="more-project-{{$project->id}}" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"
            title="{{trans('project-details.more_options_project', ['name'=>$project->name])}}">
        <span class="sr-only">{{trans('project-details.more_options_project', ['name'=>$project->name])}}</span>
        <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="more-project-{{$project->id}}">
        <a href="{{route('system.permissions.index', $project->id)}}" class="dropdown-item btn btn-link permissions-project-btn">{{trans('project-details.permissions')}}</a>
        <div class="dropdown-divider"></div>
        <button class="dropdown-item btn btn-link rename-project-btn">{{trans('project-details.rename')}}</button>
        @if($project->father_project != "")
        <button class="dropdown-item btn btn-link move-project-btn">{{trans('project-details.move')}}</button>
        @endif
        <div class="dropdown-divider"></div>
        <button class="dropdown-item btn btn-link delete-project-btn">{{trans('project-details.delete')}}</button>
    </div>
</div>
