<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    function getProjectPermissions($project_id)
    {
        $current_project = Project::findOrFail($project_id);
        return view('project-share')
            ->with('project', $current_project)
            ->with('path', ProjectController::getProjectChain($current_project));
    }

    function addPermission($project_id, Request $request)
    {
        \Validator::make($request->all(), [
            'email' => 'bail|required|email|exists:users,email',
            'modify' => 'in:true,false',
            'add' => 'in:true,false',
            'remove' => 'in:true,false',
        ])->validate();
        $current_project = Project::findOrFail($project_id);
        $user = User::whereEmail($request->email)->get()->first();

        if ($user->id !== \Auth::user()->id) {
            $current_project->users()->attach($user->id, [
                'read' => true,
                'modify' => $request->modify == 'true' ?? false,
                'add' => $request->add == 'true' ?? false,
                'remove' => $request->remove == 'true' ?? false
            ]);
        }
        return redirect(route('system.permissions.index', $project_id));
    }

    function editPermission($project_id, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'bail|required|exists:users,id|exists:project_user,user_id',
            'permission' => 'required|in:modify,add,remove',
            'value' => 'in:true,false',
        ]);
        if ($validator->fails()) {
            return json_encode(array('done' => false, 'errors' => $validator->errors()->toArray()));
        }

        Project::findOrFail($project_id)
            ->users()
            ->updateExistingPivot($request->user_id, [$request->permission => $request->value == 'true']);

        return json_encode(array('done' => true));
    }

    function deletePermission($project_id, $user_id)
    {
        Project::findOrFail($project_id)->users()->detach($user_id);
        return redirect(route('system.permissions.index', $project_id));
    }
}
