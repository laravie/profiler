<?php

namespace Laravie\Profiler;

use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(Contracts\Profiler::class, function ($app) {
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
            Contracts\Profiler::class,
        ];
    }
}
