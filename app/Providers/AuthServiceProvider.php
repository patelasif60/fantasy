<?php

namespace App\Providers;

use Aecor\MasterPassword\JWTGuard;
use App\Models\CustomCup;
use App\Models\Division;
use App\Models\Team;
use App\Policies\CustomCupPolicy;
use App\Policies\DivisionPolicy;
use App\Policies\PastWinnerHistory;
use App\Policies\PastWinnerHistoryPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Division::class => DivisionPolicy::class,
        CustomCup::class => CustomCupPolicy::class,
        PastWinnerHistory::class => PastWinnerHistoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerAuthGuards();
    }

    public function registerAuthGuards()
    {
        $this->app['auth']->extend('jwt', function ($app, $name, array $config) {
            $guard = new JWTGuard(
                $app['tymon.jwt'],
                $app['auth']->createUserProvider($config['provider']),
                $app['request']
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });
    }
}
