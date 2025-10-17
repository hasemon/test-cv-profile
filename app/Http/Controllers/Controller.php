<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Success JSON Response Method.
     *
     * @param string $message
     * @param null $data
     * @param null $total
     * @return JsonResponse
     */
    public function successJsonResponse(string $message, $data = NULL, $total = NULL): JsonResponse
    {
        return response()->json([
            'status' => TRUE,
            'message' => $message,
            'data' => $data ?: [],
            'total' => $total ?: ((is_null($data) ? 0 : (is_array($data) ? count($data) : 1)))
        ]);
    }

    /**
     * Error JSON Response Method.
     *
     * @param string $message
     * @param array $data
     * @param int $status
     *
     * @return JsonResponse
     */
    public function errorJsonResponse(string $message, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => FALSE,
            'message' => $message ?: 'Something went wrong! Please try again later.',
            'data' => $data,
            'total' => 0,
        ], $status);
    }

    /**
     * Exception JSON Response.
     *
     * @param $exception
     * @param string|null $message
     * @return JsonResponse
     */
    public function exceptionJsonResponse($exception, string $message = NULL): JsonResponse
    {
        return response()->json([
            'status' => FALSE,
            'message' => $message ?? 'Something went wrong! Please try again later.',
            'data' => [
                'exceptions' => $exception->getMessage()
            ],
            'total' => 0,
        ]);
    }
}
