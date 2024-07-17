<?php

namespace Aecor\MasterPassword;

class MasterPassword
{
    /**
     * Create a new MasterPassword Instance.
     */
    public function __construct()
    {
        // constructor body
    }

    public static function isEnabled()
    {
        return config('master-password.enabled');
    }

    public static function isMasterLogin()
    {
        return session('is_master_login', false);
    }
}
