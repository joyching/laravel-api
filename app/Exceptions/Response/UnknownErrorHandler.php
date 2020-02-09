<?php

namespace App\Exceptions\Response;

class UnknownErrorHandler implements IResponseHandler
{
    /**
     * Render json string into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'message' => 'Unknown Error',
            'errors' => [
                [
                    'code' => 'E9999',
                    'description' => 'Unknown error occurred!'
                ]
            ]
        ], 500);
    }
}
