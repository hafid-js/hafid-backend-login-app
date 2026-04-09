<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtFromCookie
{
    public function handle($request, Closure $next)
{
    $token = $request->cookie('token');

    if ($token) {
        $request->headers->set('Authorization', 'Bearer ' . $token);
    }

    return $next($request);
}
}
