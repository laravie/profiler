<?php

namespace Laravie\Profiler\Tests\Events;

use Mockery as m;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Laravie\Profiler\Tests\Stubs\User;
use Laravie\Profiler\Contracts\Profiler;
use Laravie\Profiler\Events\DatabaseQuery;
use Illuminate\Database\Events\QueryExecuted;

class DatabaseQueryTest extends TestCase
{
    /** @test */
    public function query_should_be_logged()
    {
        $profiler = app(Profiler::class);
        $profiler->extend(new DatabaseQuery());

        $user = factory(User::class);

        $user->create();
    }

    /** @test */
    public function accepts_query_executed_event()
    {
        $this->app->instance('log', $logger = m::mock(LogManager::class));

        $logger->shouldReceive('info')->once()->with('<comment>SELECT * FROM `foo` WHERE id=1 [1ms]</comment>')
            ->shouldReceive('info')->once()->with('<comment>SELECT * FROM `users` WHERE id=10 [3ms]</comment>')
            ->shouldReceive('info')->with(m::type('String'));

        $db = app('db');
        $profiler = app(Profiler::class);
        $profiler->extend(new DatabaseQuery());

        event(new QueryExecuted('SELECT * FROM `foo` WHERE id=?', [1], 1, $db));
        event(new QueryExecuted('SELECT * FROM `users` WHERE id=?', [10], 3, $db));
    }
}
