<?php

namespace Laravie\Profiler\TestCase\Events;

use Mockery as m;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Laravie\Profiler\Events\Request;
use Illuminate\Support\Facades\Route;
use Laravie\Profiler\TestCase\TestCase;
use Laravie\Profiler\Contracts\Profiler;

class RequestTest extends TestCase
{
    /** @test */
    function log_visit_to_page()
    {
        $this->app->instance('log', $logger = m::mock(LoggerInterface::class));
        $monolog = m::mock(Logger::class);

        $logger->shouldReceive('getMonolog')->once()->andReturn($monolog);
        $monolog->shouldReceive('addInfo')->once()->with('<info>Request: GET localhost/</info>');

        app(Profiler::class)->extend(new Request());
    }
}
