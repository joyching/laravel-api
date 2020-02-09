<?php

namespace App\Libraries\Extensions\Passport;

use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\PassportServiceProvider as BasePassportServiceProvider;

class PassportServiceProvider extends BasePassportServiceProvider
{
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(\Laravel\Passport\Bridge\ClientRepository::class),
            $this->app->make(\App\Libraries\Extensions\Passport\AccessTokenRepository::class),
            $this->app->make(\Laravel\Passport\Bridge\ScopeRepository::class),
            $this->makeCryptKey('private'),
            app('encrypter')->getKey()
        );
    }
}
