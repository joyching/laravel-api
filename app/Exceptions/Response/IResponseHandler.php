<?php

namespace App\Exceptions\Response;

interface IResponseHandler
{
    /**
     * Render json string into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render();
}
