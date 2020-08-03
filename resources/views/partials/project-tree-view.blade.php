<li class="nav-item">
    @if($main_project->sub_projects->isEmpty())
        <a class="nav-link" href="{{route('system.project-details', $main_project->id)}}">
            <span aria-hidden="true" class="fas fa-folder mr-1"></span>
            {{$main_project->name}}
        </a>
    @else
        <div class="btn-group collapse-button-container">
            <a type="button" class="nav-link collapse-button" data-toggle="collapse"
               href="#sidebar-project-tree-{{$main_project->id}}"
               role="button" aria-expanded="false" aria-controls="sidebar-project-tree-{{$main_project->id}}"></a>
            <a class="nav-link"
               href="{{route('system.project-details', $main_project->id)}}">
                <span aria-hidden="true" class="project-sidebar-icon mr-1"></span>
                {{$main_project->name}}
            </a>
        </div>
        <ul class="collapse el-3dp nav flex-column flex-nowrap" id="sidebar-project-tree-{{$main_project->id}}">
            @each('partials.project-tree-view', $main_project->sub_projects, 'main_project')
        </ul>
    @endif
</li>
