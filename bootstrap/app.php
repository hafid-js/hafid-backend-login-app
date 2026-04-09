<?php

use App\Http\Middleware\JwtFromCookie;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api([
        JwtFromCookie::class,
    ]);
    })
    ->withExceptions(function ($exceptions) {

    $exceptions->render(function (ValidationException $e, $request) {

        $errors = $e->errors();

        if (isset($errors['auth'])) {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal',
                'errors' => $errors
            ], 401);
        }

        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $errors
        ], 422);
    });


$exceptions->render(function (TokenExpiredException $e, $request) {
    return response()->json([
        'success' => false,
        'message' => 'Token expired'
    ], 401);
});

$exceptions->render(function (TokenInvalidException $e, $request) {
    return response()->json([
        'success' => false,
        'message' => 'Token tidak valid'
    ], 401);
});

$exceptions->render(function (UnauthorizedHttpException $e, $request) {
    return response()->json([
        'success' => false,
        'message' => 'Unauthenticated'
    ], 401);
});
    })->create();
