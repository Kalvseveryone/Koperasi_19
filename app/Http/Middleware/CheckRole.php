<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Get the user's role from the user type
        $userRole = $request->user() instanceof \App\Models\Kolektor ? 'kolektor' : 'admin';

        if (!in_array($userRole, $roles)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            
            // Redirect to appropriate dashboard based on role
            if ($userRole === 'kolektor') {
                return redirect()->route('kolektor.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
