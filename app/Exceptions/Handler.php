<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Exception|Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {

            return response()->json([
                'status' => false,
                'message' => ucfirst((new ReflectionClass(resolve($e->getModel())))->getShortName()) . ' information not found for the given ID. Please try again with another ID',
                'data' => [],
            ]);
        }

        if ($e instanceof NotFoundHttpException) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Route not found',
                    'data' => [],
                    'total' => 0
                ], 404);
            }
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'HTTP method not allowed',
                    'data' => [],
                    'total' => 0
                ], 404);
            }
        }

        if ($e instanceof AuthenticationException) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated',
                    'data' => [],
                    'total' => 0
                ], 401);
            }
        }

        if ($e instanceof AuthorizationException) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized action',
                    'data' => [],
                    'total' => 0
                ], 403);
            }
        }

        return parent::render($request, $e);
    }
}
