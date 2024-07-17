<?php

namespace Aecor\MasterPassword;

use Illuminate\Auth\EloquentUserProvider as LaravelUserProvider;

class MasterPasswordDatabaseUserProvider extends LaravelUserProvider
{
    use ValidatesCredentials;
}
