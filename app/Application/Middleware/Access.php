<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Access
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permissions
     * @param string $access
     * @return mixed
     */
    public function handle($request, Closure $next, string $permissions, string $access)
    {
        $user = Auth::user();

        $permissions = explode('|', $permissions);

        if (in_array('*', $permissions)) {
            return $next($request);
        }

        foreach ($permissions as $permission) {
            if ($access == '*') {
                return $next($request);
            }

            if (Auth::user()->hasAccess($user, $permission, $access)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Forbidden Access'], 403);

    }
}
