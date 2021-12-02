<?php

namespace App\Application\Middleware;

use Closure;

class CheckForTimezone
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
        $globalTimezone = $request->header('timezone') ?? 'UTC';
        config(['global.timezone' => $globalTimezone]);

        return $next($request);
    }
}
