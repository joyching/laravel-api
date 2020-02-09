<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Traits\Auth\UserSignature;
use App\Http\Controllers\Controller;
use App\Exceptions\User\InvalidCredentialException;

class AuthenticationController extends Controller
{
    use UserSignature;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (! $this->attemptLogin($request)) {
            throw new InvalidCredentialException;
        }

        $user = $request->user();
        $tokenResult = $user->createToken('api_user_' . $user->id);

        $this->refreshUserSignature($user, $tokenResult->accessToken);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_in' => $tokenResult->token->expires_at->timestamp - time(),
            'user' => [
                'id' => $user->id,
                'email' => $user->email
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->update(['signature' => '']);
        $request->user()->token()->revoke();

        return response()->json(['logout_time' => now()->timestamp]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return auth()->attempt($this->credentials($request));
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }
}
