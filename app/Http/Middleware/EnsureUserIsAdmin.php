<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->role || strtolower($user->role->name) !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
