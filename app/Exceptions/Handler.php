<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ApiExceptionHandler::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $handler = $this->findExceptionResponseHandler($exception);

        if (!is_null($handler)) {
            return $handler->render();
        }

        if (!method_exists($exception, 'getErrorTitle')) {
            $handler = new Response\UnknownErrorHandler;

            return $handler->render();
        }

        return parent::render($request, $exception);
    }

    /**
     * To find response handler from exception.
     *
     * @param  \Exception  $exception
     * @return object|null
     */
    private function findExceptionResponseHandler(Exception $exception)
    {
        switch (true) {
            case $exception instanceof NotFoundHttpException:
            case $exception instanceof MethodNotAllowedHttpException:
                return new Response\InvalidHttpRoutungHandler;

            case $exception instanceof ModelNotFoundException:
            case $exception instanceof ResourceNotFoundException:
                return new Response\InvalidResourceRequestHandler;

            case $exception instanceof AuthenticationException:
                return new Response\InvalidTokenHandler;

            case $exception instanceof ValidationException:
                return new Response\InvalidParameterHandler($exception);
        }

        return null;
    }
}
