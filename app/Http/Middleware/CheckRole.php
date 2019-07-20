<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if(!Auth::check()) {
            abort(500); 
        }

        $user = Auth::user();

        foreach($roles as $role) {
            if($role == $user->user_type) {
                return $next($request);
            }
        }

        abort(500);
    }
}

