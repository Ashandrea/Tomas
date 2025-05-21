<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Split roles by pipe to allow multiple roles
        $allowedRoles = explode('|', $roles);
        
        if (!in_array($request->user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}