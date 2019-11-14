<?php

namespace Laravie\Profiler\Tests;

use Mockery as m;
use Laravie\Profiler\Timer;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Contracts\Profiler;

class TimerTest extends TestCase
{
    /** @test */
    public function timer_can_be_initiated()
    {
        $timer = app(Profiler::class)->time('foo');

        $this->assertInstanceOf(Timer::class, $timer);
        $this->assertEquals('foo', $timer);
        $this->assertSame('foo', $timer->name);
    }

    /** @test */
    public function timer_can_output_to_monolog()
    {
        $this->app->instance('log', $logger = m::mock(LogManager::class));

        $logger->shouldReceive('info')->once()->with('Hello world', []);

        $timer = app(Profiler::class)->time('foo', 'Hello world');

        $this->assertNull($timer->end());
    }

    /** @test */
    public function timer_is_not_duplicated_when_given_the_same_name()
    {
        $timer1 = app(Profiler::class)->time('foo');
        $timer2 = app(Profiler::class)->time('foo');

        $this->assertSame('foo', $timer1->name);
        $this->assertSame('foo', $timer2->name);
        $this->assertNotSame($timer1, $timer2);
    }

    /** @test */
    public function timer_can_be_ended_without_start()
    {
        $this->app->instance('log', $logger = m::mock(LogManager::class));

        $logger->shouldReceive('info')->once()->with(m::type('String'), []);

        defined('LARAVEL_START') || define('LARAVEL_START', microtime(true));

        $profiler = app(Profiler::class);

        $this->assertNull($profiler->timeEnd('foo'));
    }

    /** @test */
    public function timer_can_be_ended_using_name()
    {
        $this->app->instance('log', $logger = m::mock(LogManager::class));

        $logger->shouldReceive('info')->once()->with('Goodbye world', []);

        defined('LARAVEL_START') || define('LARAVEL_START', microtime(true));

        $profiler = app(Profiler::class);
        $timer = $profiler->time('foo', 'Goodbye world');

        $this->assertNull($profiler->timeEnd('foo'));
    }
}
