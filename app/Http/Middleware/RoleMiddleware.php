<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $guard = 'api')
    {

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        $user = Auth::guard($guard)->user();

        if(!$user) 
        {
            return response()->json([
                'message' => 'Anda tidak berhak mengakses jaringan ' . $guard
            ], 403);
        }

        if (! $user->hasAnyRole($roles)) {

            return response()->json([
                'message' => 'Anda tidak memiki Hak Akses untuk aksi ini'
            ], 403);
        }

        return $next($request);
    }
}
