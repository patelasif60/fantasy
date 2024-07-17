<?php

namespace Aecor\MasterPassword;

use Illuminate\Auth\SessionGuard as BaseSessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;

class SessionGuard extends BaseSessionGuard
{
    public function attemptWithMasterPassword(array $credentials = [])
    {
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials(array_only($credentials, ['email', 'username']));

        // If an implementation of UserInterface was returned, we'll ask the provider
        // to validate the user against the given credentials, and if they are in
        // fact valid we'll log the users into the application and return true.
        if ($this->hasValidMasterCredentials($user, $credentials)) {
            $this->quietLogin($user);

            return true;
        }

        return false;
    }

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     * @return bool
     */
    protected function hasValidMasterCredentials($user, $credentials)
    {
        return ! is_null($user) && $this->provider->validateMasterCredentials($user, $credentials);
    }

    /**
     * Log a user into the application without firing the Login event.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function quietLogin(Authenticatable $user)
    {
        $this->updateSession($user->getAuthIdentifier());
        $this->session->put('is_master_login', true);

        $this->setUser($user);
    }

    /**
     * Logout the user without updating remember_token
     * and without firing the Logout event.
     *
     * @param   void
     * @return  void
     */
    public function quietLogout()
    {
        $this->clearUserDataFromStorage();
        $this->user = null;
        $this->loggedOut = true;
    }
}
