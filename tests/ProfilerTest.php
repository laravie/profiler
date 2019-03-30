<?php

namespace Laravie\Profiler\Tests;

use Mockery as m;
use Monolog\Logger;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Contracts\Listener;
use Laravie\Profiler\Contracts\Profiler;

class ProfilerTest extends TestCase
{
    /** @test */
    function can_attach_listener()
    {
        $listener = m::mock(Listener::class);

        $listener->shouldReceive('handle')->with(m::type(LogManager::class))->andReturnNull();

        $this->assertInstanceOf(Profiler::class, app(Profiler::class)->extend($listener));
    }
}
