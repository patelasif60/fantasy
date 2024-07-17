<?php

namespace Aecor\MasterPassword;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Skeleton\Password
 */
class MasterPasswordFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'master-password';
    }
}
