<?php

namespace Emotionally\Http\Middleware;

use Closure;
use Emotionally\User;

class ProjectPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permission_required The required permission. Must be one
     * of: 'read', 'modify', 'add', 'remove', 'admin' (case unsensitive).
     * @param string|null $key if given, it will be used as key to fetch the project ID from the request.
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_required, $key = null)
    {
        if ($key) {
            if($key == 'father_id' && (!$request->has($key) || $request->input($key) !== null)){
                return $next($request);
            }

            $id = $request->input($key);
        } else {
            $id = array_key_exists('id', $request->route()->parameters()) ?
                $request->route()->parameters()['id'] : $request->route()->parameters()['project_id'];
        }

        $is_admin = $request->user()->projects->contains('id', $id);
        if (!$is_admin) {
            $has_permission = $permission_required != 'admin' && $request->user()
                    ->permissions()
                    ->where('id', $id)
                    ->wherePivot($permission_required, true)
                    ->get()
                    ->isNotEmpty();

            if (!$has_permission) {
                return abort(403);
            }
        }

        return $next($request);
    }
}
