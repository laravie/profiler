<?php

namespace Laravie\Profiler\Traits;

use Laravie\Profiler\Timer;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Contracts\Timer as TimerContract;

trait Timing
{
    /**
     * List of timers.
     *
     * @var array
     */
    protected $timers = [];

    /**
     * Time a process.
     *
     * @param  string       $name
     * @param  string|null  $message
     *
     * @return \Laravie\Profiler\Contracts\Timer
     */
    public function time(string $name, string $message = null): TimerContract
    {
        $id = isset($this->timers[$name]) ? uniqid($name) : $name;

        $this->timers[$id] = $this->createTimer($name, microtime(true), $message);

        return $this->timers[$id];
    }

    /**
     * Calculate timed taken for a process to complete.
     *
     * @param  \Laravie\Profiler\Contracts\Timer|string|null  $name
     *
     * @return void
     */
    public function timeEnd($name = null): void
    {
        $timer = $name instanceof TimerContract ? $name : $this->resolveTimerFromName($name);

        $timer->end();
    }

    /**
     * Resolve timer from name.
     *
     * @param  string|null $name
     *
     * @return \Laravie\Profiler\Contracts\Timer
     */
    protected function resolveTimerFromName(string $name = null): TimerContract
    {
        $id = is_null($name) ? uniqid() : $name;

        if (isset($this->timers[$id])) {
            return $this->timers[$id];
        }

        return $this->createTimer($name, constant('LARAVEL_START'));
    }

    /**
     * Create a new timer.
     *
     * @param string  $name
     * @param int|float  $startedAt
     * @param string|null  $message
     *
     * @return \Laravie\Profiler\Contracts\Timer
     */
    protected function createTimer(string $name, $startedAt, string $message = null): TimerContract
    {
        return (new Timer($name, $startedAt, $message))->setLogger($this->getLogger());
    }

    /**
     * Get the log manager instance.
     *
     * @return \Illuminate\Log\LogManager
     */
    abstract public function getLogger(): LogManager;
}
