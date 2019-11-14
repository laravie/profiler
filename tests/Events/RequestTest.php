<?php

namespace Laravie\Profiler\Tests\Events;

use Mockery as m;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Events\Request;
use Laravie\Profiler\Tests\TestCase;
use Laravie\Profiler\Contracts\Profiler;

class RequestTest extends TestCase
{
    /** @test */
    public function log_visit_to_page()
    {
        $this->app->instance('log', $logger = m::mock(LogManager::class));

        $logger->shouldReceive('info')->once()->with('<info>Request: GET localhost/</info>');

        app(Profiler::class)->extend(new Request());
    }
}
