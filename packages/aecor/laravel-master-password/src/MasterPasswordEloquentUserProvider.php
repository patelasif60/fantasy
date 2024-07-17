<?php

namespace Aecor\MasterPassword;

use Illuminate\Auth\EloquentUserProvider as LaravelUserProvider;

class MasterPasswordEloquentUserProvider extends LaravelUserProvider
{
    use ValidatesCredentials;
}
