<?php

namespace Aecor\MasterPassword;

use Tymon\JWTAuth\JWTGuard as BaseGuard;

class JWTGuard extends BaseGuard
{
    public function attemptWithMasterCredentials(array $credentials = [], $login = true)
    {
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials(array_only($credentials, ['email', 'username']));

        if ($user && $this->provider->validateMasterCredentials($user, $credentials)) {
            return $login ? $this->login($user) : true;
        }

        return false;
    }

    public function isMasterLogin()
    {
        if (! $this->jwt) {
            return false;
        }

        return (bool) $this->jwt->getClaim('is_master_login');
    }
}
