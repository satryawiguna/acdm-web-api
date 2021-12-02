<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfSwaggerAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!Auth::user()->hasRole($user, 'developer')) {
            return redirect('/home');
        }

        return $next($request);
    }
}
