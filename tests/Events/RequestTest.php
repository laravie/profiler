<?php

namespace Laravie\Profiler\TestCase\Events;

use Mockery as m;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Events\Request;
use Illuminate\Support\Facades\Route;
use Laravie\Profiler\TestCase\TestCase;
use Laravie\Profiler\Contracts\Profiler;

class RequestTest extends TestCase
{
    /** @test */
    function log_visit_to_page()
    {
        $this->app->instance('log', $logger = m::mock(LogManager::class));

        $logger->shouldReceive('info')->once()->with('<info>Request: GET localhost/</info>');

        app(Profiler::class)->extend(new Request());
    }
}
