<?php

namespace App\Exceptions\User;

use App\Exceptions\ApiExceptionHandler;

class UserAccountWasTakenException extends ApiExceptionHandler
{
    public function __construct($errorTitle = 'Register Error', $errorDescription = 'Email was taken.', $errorCode = 'E0101')
    {
        $this->httpCode = 422;
        $this->errorTitle = $errorTitle;
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;
    }
}
