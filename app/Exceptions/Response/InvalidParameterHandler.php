<?php

namespace App\Exceptions\Response;

use Illuminate\Validation\ValidationException;

class InvalidParameterHandler implements IResponseHandler
{
    private $exception;

    public function __construct(ValidationException $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Render json string into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        $errors = [];

        foreach ($this->exception->validator->errors()->getMessages() as $field => $message) {
            $errors[] = ['field' => $field, 'description' => $message[0]];
        }

        return response()->json([
            'message' => 'Validation Error',
            'errors' => $errors
        ], 422);
    }
}
