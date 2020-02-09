<?php

namespace App\Traits\Auth;

use App\Models\User;
use Lcobucci\JWT\Parser;

trait UserSignature
{
    protected function parseTokenSignature($jwt) : string
    {
        $token = (new Parser())->parse($jwt);

        return $token->getClaim('signature');
    }

    protected function refreshUserSignature(User $user, $token) : void
    {
        $signature = $this->parseTokenSignature($token);

        $user->update(['signature' => $signature]);
    }
}
