<?php

namespace App\Exceptions\Response;

class InvalidHttpRoutungHandler implements IResponseHandler
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
                    'code' => 'E9002',
                    'description' => 'HTTP not found!'
                ]
            ]
        ], 404);
    }
}
