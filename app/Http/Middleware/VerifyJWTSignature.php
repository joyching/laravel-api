<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\Auth\UserSignature;
use App\Exceptions\Authorization\TokenUserNotDefinedException;

class VerifyJWTSignature
{
    use UserSignature;

    /**
     * Handle an incoming request.
     *
     * testing環境因Passport mock user auth，Header Authorization會為null
     * 因而避免此段解析jwt token處理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->headers->get('Authorization');

        if (! is_null($authorization)) {
            $currentSignature = auth()->user()->signature;

            $jwt = trim(preg_replace('/^(?:\s+)?Bearer\s/', '', $authorization));
            $signature = $this->parseTokenSignature($jwt);

            if (strcmp($currentSignature, $signature) !== 0) {
                throw new TokenUserNotDefinedException;
            }
        }

        return $next($request);
    }
}
