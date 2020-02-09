<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Auth\UserSignature;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use UserSignature;

    /**
     * To register by email and password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Reponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->registered($request);

        $user = $this->create($request->all());
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * 檢查是否該email已註冊過
     *
     * @param \Illuminate\Http\Request $request
     * @throws \App\Exceptions\User\UserAccountWasTakenException
     */
    protected function registered(Request $request)
    {
        $user = User::ofRegistered($request->email)->first();

        if (!is_null($user)) {
            throw new UserAccountWasTakenException;
        }
    }
}
