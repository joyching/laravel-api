<?php

namespace App\Exceptions\User;

use App\Exceptions\ApiExceptionHandler;

class InvalidCredentialException extends ApiExceptionHandler
{
    public function __construct($errorTitle = 'Authorization Error', $errorDescription = 'Invalid Credential.', $errorCode = 'E0102')
    {
        $this->httpCode = 401;
        $this->errorTitle = $errorTitle;
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;
    }
}
