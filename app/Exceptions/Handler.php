<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Exception;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (Exception $exception) {
            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthenticated',
                    'errors' => $exception->getMessage()
                ], 401);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Not Found',
                    'errors' => $exception->getMessage()
                ], 404);
            }

            if ($exception instanceof QueryException) {
                return response()->json([
                    'message' => 'Not Found',
                    'errors' => 'Resources not found'
                ], 404);
            }

            if ($exception instanceof HttpException) {
                return response()->json([
                    'message' => 'Not Found',
                    'errors' => 'Resources not found'
                ], 404);
            }
        });
    }
}
