<?php

namespace Laravie\Profiler\TestCase;

use Mockery as m;
use Monolog\Logger;
use Laravie\Profiler\Contracts\Profiler;
use Laravie\Profiler\Contracts\Listener;

class ProfilerTest extends TestCase
{
    /** @test */
    function can_attach_listener()
    {
        $listener = m::mock(Listener::class);

        $listener->shouldReceive('handle')->with(m::type(Logger::class))->andReturnNull();

        $this->assertInstanceOf(Profiler::class, app(Profiler::class)->extend($listener));
    }
}
