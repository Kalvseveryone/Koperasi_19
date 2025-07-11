<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check kolektor guard first
        if (Auth::guard('kolektor')->check()) {
            $userRole = 'kolektor';
        }
        // Then check web guard (admin)
        else if (Auth::guard('web')->check()) {
            $userRole = 'admin';
        }
        // If no user is authenticated
        else {
            return redirect()->route('login');
        }

        if (!in_array($userRole, $roles)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
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
