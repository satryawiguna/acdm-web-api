<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, string $permissions)
    {
        $user = Auth::user();

        $permissions = explode('|', $permissions);

        if (in_array('*', $permissions)) {
            return $next($request);
        }

        foreach ($permissions as $permission) {
            if (Auth::user()->hasPermission($user, $permission)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Forbidden Permission'], 403);
    }
}
