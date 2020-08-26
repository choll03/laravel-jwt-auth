<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission, $guard)
    {

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        $user = Auth::guard($guard)->user();

        if(!$user) 
        {
            return response()->json([
                'message' => 'Anda tidak berhak mengakses jaringan ' . $guard
            ], 403);
        }

        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'Anda tidak memiki Hak Akses untuk aksi ini'
        ], 403);
    }
}