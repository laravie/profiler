<?php

namespace Laravie\Profiler;

use Illuminate\Support\ServiceProvider;
use Laravie\Profiler\Contracts\Profiler as ProfilerContract;

class ProfilerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProfilerContract::class, function ($app) {
            return new Profiler($app->make('log')->getMonolog());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ProfilerContract::class,
        ];
    }
}
