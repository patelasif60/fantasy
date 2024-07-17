<?php

namespace Aecor\MasterPassword;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

trait ValidatesCredentials
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateMasterCredentials(UserContract $user, array $credentials)
    {
        $token = $user->masterPasswords()->active()->latest()->get()->first(function ($master) use ($credentials) {
            if ($this->hasher->check($credentials['password'], $master->password)) {
                return true;
            }
        });

        if (! $token) {
            return false;
        }

        $token->markAsUsed();

        return true;
    }
}
