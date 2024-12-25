<?php

// app/Http/Middleware/ValidUser.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // Additional parameter for roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next,...$role)
    {
        // dd($role);
        // Check if the user has the given role
        // if (!auth()->check() || !auth()->user()->hasRole($role)) {
        //     // Redirect if the user does not have the required role
        //     echo "fail ";die;
        //     // return redirect('home')->with('error', 'You do not have permission to access this page.');
        // }

        // Continue to the next middleware or controller
        return $next($request);
    }
}
