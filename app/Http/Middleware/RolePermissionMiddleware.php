<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolePermissionMiddleware
{
    public function handle(Request $request, Closure $next, $role = null, $permission = null)
    {
        $user = $request->user();

        if ($role && !$user->hasRole($role)) {
            echo"kjsndckf";die;
            return redirect('home')->with('error', 'Access Denied!');
        }

        if ($permission && !$user->can($permission)) {
            return redirect('home')->with('error', 'Access Denied!');
        }

        return $next($request);
    }
}
