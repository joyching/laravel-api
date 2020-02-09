<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;

class ApiExceptionHandler extends \Exception implements Responsable
{
    protected $httpCode;
    protected $errorTitle;
    protected $errorCode;
    protected $errorDescription;

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getErrorTitle()
    {
        return $this->errorTitle;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->getErrorTitle(),
            'errors' => [
                [
                    'code' => $this->getErrorCode(),
                    'description' => $this->getErrorDescription()
                ]
            ]
        ], $this->getHttpCode());
    }
}
