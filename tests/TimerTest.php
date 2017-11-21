<?php

namespace Laravie\Profiler\TestCase;

use Mockery as m;
use Monolog\Logger;
use Laravie\Profiler\Timer;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Log;
use Laravie\Profiler\Contracts\Profiler;

class TimerTest extends TestCase
{
    /** @test */
    function timer_can_be_initiated()
    {
        $timer = app(Profiler::class)->time('foo');

        $this->assertInstanceOf(Timer::class, $timer);
        $this->assertEquals('foo', $timer);
        $this->assertSame('foo', $timer->name());
    }

     /** @test */
    function timer_can_output_to_monolog()
    {
        $this->app->instance('log', $logger = m::mock(LoggerInterface::class));
        $monolog = m::mock(Logger::class);

        $logger->shouldReceive('getMonolog')->once()->andReturn($monolog);
        $monolog->shouldReceive('addInfo')->once()->with('Hello world', []);

        $timer = app(Profiler::class)->time('foo', 'Hello world');

        $this->assertNull($timer->end());
    }

    /** @test */
    function timer_is_not_duplicated_when_given_the_same_name()
    {
        $timer1 = app(Profiler::class)->time('foo');
        $timer2 = app(Profiler::class)->time('foo');

        $this->assertSame('foo', $timer1->name());
        $this->assertSame('foo', $timer2->name());
        $this->assertNotSame($timer1, $timer2);
    }

    /** @test */
    function timer_can_be_ended_without_start()
    {
        $this->app->instance('log', $logger = m::mock(LoggerInterface::class));
        $monolog = m::mock(Logger::class);

        $logger->shouldReceive('getMonolog')->once()->andReturn($monolog);
        $monolog->shouldReceive('addInfo')->once()->with(m::type('String'), []);

        defined('LARAVEL_START') || define('LARAVEL_START', microtime(true));

        $profiler = app(Profiler::class);

        $this->assertNull($profiler->timeEnd('foo'));
    }

    /** @test */
    function timer_can_be_ended_using_name()
    {
        $this->app->instance('log', $logger = m::mock(LoggerInterface::class));
        $monolog = m::mock(Logger::class);

        $logger->shouldReceive('getMonolog')->once()->andReturn($monolog);
        $monolog->shouldReceive('addInfo')->once()->with('Goodbye world', []);

        defined('LARAVEL_START') || define('LARAVEL_START', microtime(true));

        $profiler = app(Profiler::class);
        $timer = $profiler->time('foo', 'Goodbye world');

        $this->assertNull($profiler->timeEnd('foo'));
    }
}
