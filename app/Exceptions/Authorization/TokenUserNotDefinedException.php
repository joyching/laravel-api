<?php

namespace App\Exceptions\Authorization;

use App\Exceptions\ApiExceptionHandler;

class TokenUserNotDefinedException extends ApiExceptionHandler
{
    public function __construct($errorTitle = 'Authorization Error', $errorDescription = 'Could not get user from token!', $errorCode = 'E0002')
    {
        $this->httpCode = 401;
        $this->errorTitle = $errorTitle;
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;
    }
}
