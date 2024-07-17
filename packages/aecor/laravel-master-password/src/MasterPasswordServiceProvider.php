<?php

namespace Aecor\MasterPassword;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MasterPasswordServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/master-password.php' => config_path('master-password.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerAuthDriver();
        $this->registerAuthProviders();

        $this->mergeConfigFrom(__DIR__.'/../config/master-password.php', 'master-password');

        $this->app->singleton(MasterPassword::class, function () {
            return new MasterPassword();
        });

        $this->app->alias(MasterPassword::class, 'master-password');

        if (MasterPassword::isEnabled()) {
            $this->changeUsersDriver();
        }
    }

    private function registerAuthProviders()
    {
        \Auth::provider('eloquentMasterPassword', function ($app, array $config) {
            return new MasterPasswordEloquentUserProvider($app['hash'], $config['model']);
        });
        \Auth::provider('databaseMasterPassword', function ($app, array $config) {
            return new MasterPasswordDatabaseUserProvider($app['db']->connection(), $app['hash'], $config['table']);
        });
    }

    private function changeUsersDriver()
    {
        $driver = config()->get('auth.providers.users.driver');
        if (in_array($driver, ['eloquent', 'database'])) {
            config()->set('auth.providers.users.driver', $driver.'MasterPassword');
        }
    }

    private function registerAuthDriver()
    {
        $auth = $this->app['auth'];
        $auth->extend('session', function (Application $app, $name, array $config) use ($auth) {
            $provider = $auth->createUserProvider($config['provider']);
            $guard = new SessionGuard($name, $provider, $app['session.store']);
            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }
            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }
            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;
        });
    }
}
