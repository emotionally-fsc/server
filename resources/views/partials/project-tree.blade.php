<li class="my-1">
    <button class="btn btn-outline-primary btn-list-project" aria-labelledby="project-{{$main_project->id}}"
            onclick="selectProject(this,{{$main_project->id}})">
        <span class="fas fa-folder mr-1"></span>{{$main_project->name}}</button>
</li>
