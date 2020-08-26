<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {

            $user = auth($guard)->check() ? auth($guard)->user() : null;

            if(!$user) {
                return response()->json([
                    'message'   => 'Akses ditolak',
                    'token'     => false
                ], 401);
            }
            
        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json(['message' => 'Token is Invalid'], 400);
            } 
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json([
                    'message'   => 'Token Expired',
                    'token'     => true
                ], 401);
            } 
            else 
            {
                return response()->json([
                    'message'   => 'Anda harus login terlebih dahulu',
                    'token'     => false
                ], 401);
            }
        }

        return $next($request);
    }
}
