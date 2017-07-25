<?php

namespace Laravie\Profiler\TestCase;

use Laravie\Profiler\ProfilerServiceProvider;
use Orchestra\Testbench\TestCase as Testbench;

abstract class TestCase extends Testbench
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ProfilerServiceProvider::class,
        ];
    }
}
