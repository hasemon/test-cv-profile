<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;

class ValidationException extends HttpResponseException
{
    public function __construct(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => false,
            'message' => $validator->errors()->first(),
            'data' => [
                'errors' => $validator->errors()
            ],
        ]);

        parent::__construct($response);
    }
}
