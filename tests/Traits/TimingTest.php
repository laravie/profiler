<?php

namespace Laravie\Profiler\TestCase\Traits;

use Mockery as m;
use Laravie\Profiler\Timer;
use PHPUnit\Framework\TestCase;
use Laravie\Profiler\Traits\Timing;

class TimingTest extends TestCase
{
    use Timing;

    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     */
    public function testTimerMethod()
    {
        $this->timers = [];
        $this->monolog = $monolog = m::mock('\Monolog\Logger');

        $monolog->shouldReceive('addInfo')->twice()->with(m::type('String'));

        $timer1 = $this->time('foo');
        $timer2 = $this->time('foo');

        $this->assertEquals('foo', $timer1);
        $this->assertInstanceOf(Timer::class, $timer1);

        $this->assertInstanceOf(Timer::class, $timer2);
        $this->assertSame($timer1->name(), $timer2->name());

        $this->assertNUll($timer1->end());
        $this->assertNUll($this->timeEnd($timer2));
    }

    /**
     * @test
     */
    public function testTimerNameCannotBeUsedTwice()
    {
        $this->timers = [];
        $this->monolog = $monolog = m::mock('\Monolog\Logger');

        $timer1 = $this->time('foobar');
        $timer2 = $this->time('foobar');

        $this->assertSame('foobar', $timer1->name());
        $this->assertSame('foobar', $timer2->name());
        $this->assertNotSame($timer1, $timer2);
    }

    /**
     * @test
     */
    public function testTimerMethodWithoutCallingStartTime()
    {
        $this->timers = [];
        $this->monolog = $monolog = m::mock('\Monolog\Logger');

        defined('LARAVEL_START') || define('LARAVEL_START', microtime(true));

        $monolog->shouldReceive('addInfo')->once()->with(m::type('String'));

        $this->assertNull($this->timeEnd('foo'));
    }

    /**
     * Provides abstract method.
     *
     * @return \Monolog\Logger
     */
    public function getMonolog()
    {
        return $this->monolog;
    }
}
