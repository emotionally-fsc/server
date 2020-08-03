<style>
    .dropleft .dropdown-toggle::before {
        display: none;
    }
</style>
<div class="dropdown more-icon dropleft">
    <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
            type="button" id="more-video-{{$video->id}}" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"
            title="{{trans('project-details.more_options_video', ['name'=>$video->name])}}">
        <span class="sr-only">{{trans('project-details.more_options_video', ['name'=>$video->name])}}</span>
        <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="more-video-{{$video->id}}">
        <button class="dropdown-item btn btn-link rename-video-btn">{{trans('project-details.rename')}}</button>
        <button class="dropdown-item btn btn-link move-video-btn">{{trans('project-details.move')}}</button>
        <div class="dropdown-divider"></div>
        <button class="dropdown-item btn btn-link delete-video-btn">{{trans('project-details.delete')}}</button>
    </div>
</div>
