<?php

namespace App\Exceptions\Response;

class InvalidTokenHandler implements IResponseHandler
{
    /**
     * Render json string into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'message' => 'Authorization Error',
            'errors' => [
                [
                    'code' => 'E0001',
                    'description' => 'Invalid Token!',
                ]
            ]
        ], 401);
    }
}
