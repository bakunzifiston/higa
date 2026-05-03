<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        
        // If no roles specified, allow all authenticated users
        if (empty($roles)) {
            return $next($request);
        }
        
        if (!$user || !$user->role) {
            abort(403, 'Role not assigned');
        }

        $userRole = $user->role->slug;
        
        // Check exact match OR admin bypass
        foreach ($roles as $role) {
            if ($userRole === $role || $user->isAdmin()) {
                return $next($request);
            }
        }

        abort(403, 'Insufficient permissions');
    }

}
