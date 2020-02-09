<?php

namespace App\Exceptions\Response;

class InvalidResourceRequestHandler implements IResponseHandler
{
    /**
     * Render json string into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'message' => 'Not Found Error',
            'errors' => [
                [
                    'code' => 'E9001',
                    'description' => 'Resource not found!'
                ]
            ]
        ], 404);
    }
}
