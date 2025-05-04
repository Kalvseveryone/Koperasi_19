<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
{
    // Jika belum ada user, buat user dummy
    if (!$request->user()) {
        $fakeUser = new \stdClass();
        $fakeUser->role = 'admin'; // Atau 'user'

        $request->setUserResolver(function () use ($fakeUser) {
            return $fakeUser;
        });
    }

    if ($request->user()->role !== $role) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    return response()->json(['message' => 'Berhasil lewat role middleware']);
}

}

