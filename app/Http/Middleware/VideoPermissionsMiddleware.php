<?php

namespace Emotionally\Http\Middleware;

use Closure;
use Emotionally\User;
use Emotionally\Video;

class VideoPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permission_required The required permission. Must be one
     * of: 'read', 'modify', 'add', 'remove', 'admin' (case unsensitive).
     * @param string|null $key if given, it will be used as key to fetch the video ID from the request.
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_required, $key = null)
    {
        if ($key) {
            $id = $request->input($key);
        } else {
            $id = array_key_exists('id', $request->route()->parameters()) ?
                $request->route()->parameters()['id'] : $request->route()->parameters()['video_id'];
        }
        
        $is_admin = $request->user()->videos->contains('id', $id);
        $is_project_admin = $request->user()->projects->contains('id', Video::findOrFail($id)->project_id);
        if (!$is_admin) {
            $has_permission = $permission_required != 'admin' && 
                ($is_project_admin || $request->user()
                    ->permissions()
                    ->where('id', Video::findOrFail($id)->project_id)
                    ->wherePivot($permission_required, true)
                    ->get()
                    ->isNotEmpty());

            if (!$has_permission) {
                return abort(403);
            }
        }

        return $next($request);
    }
}
