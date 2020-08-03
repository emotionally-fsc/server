<div class="col mb-4">
    <div class="project-detail-card card h-100 text-white square"
         data-href="{{route('system.project-details', $project->id)}}">
        <div class="folder-background card-img-top"></div>
        <div class="card-img-overlay project-detail-card-title" id="card-title-project-{{$project->id}}">
            <span class="sr-only">@lang('project-details.project'): </span>
            <h5 class="card-title">{{$project->name}}</h5>
        </div>
        <a class="project-card-link" href="{{route('system.project-details', $project->id)}}"
           aria-labelledby="card-title-project-{{$project->id}}"></a>
        <div class="card-img-overlay project-detail-card-options">
            @include('shared.dropdown-options-project', ['project'=>$project])
        </div>
    </div>
</div>
