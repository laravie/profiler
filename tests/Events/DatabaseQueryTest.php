<?php

namespace Laravie\Profiler\TestCase\Events;

use Mockery as m;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Event;
use Laravie\Profiler\TestCase\TestCase;
use Laravie\Profiler\Contracts\Profiler;
use Laravie\Profiler\TestCase\Stubs\User;
use Laravie\Profiler\Events\DatabaseQuery;
use Illuminate\Database\Events\QueryExecuted;

class DatabaseQueryTest extends TestCase
{
    /** @test */
    function query_should_be_logged()
    {
        $logger = m::mock(LoggerInterface::class);
        $monolog = m::mock(Logger::class);

        $this->app->instance('log', $logger);

        $logger->shouldReceive('getMonolog')->once()->andReturn($monolog);

        $profiler = app(Profiler::class);
        $profiler->extend(new DatabaseQuery());

        $user = factory(User::class);

        $monolog->shouldReceive('addInfo')->with(m::type('String'));

        $user->create();
    }

    /** @test */
    function accepts_query_executed_event()
    {
        $logger = m::mock(LoggerInterface::class);
        $monolog = m::mock(Logger::class);

        $logger->shouldReceive('getMonolog')->once()->andReturn($monolog);
        $monolog->shouldReceive('addInfo')->once()->with('<comment>SELECT * FROM `foo` WHERE id=1 [1ms]</comment>')
            ->shouldReceive('addInfo')->once()->with('<comment>SELECT * FROM `users` WHERE id=10 [3ms]</comment>')
            ->shouldReceive('addInfo')->with(m::type('String'));

        $this->app->instance('log', $logger);

        $db = app('db');
        $profiler = app(Profiler::class);
        $profiler->extend(new DatabaseQuery());

        event(new QueryExecuted("SELECT * FROM `foo` WHERE id=?", [1], 1, $db));
        event(new QueryExecuted("SELECT * FROM `users` WHERE id=?", [10], 3, $db));
    }
}
