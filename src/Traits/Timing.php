<?php

namespace Laravie\Profiler\Traits;

use Laravie\Profiler\Timer;

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
     * @return string
     */
    public function time($name, $message = null)
    {
        $id = isset($this->timers[$name]) ? uniqid($name) : $name;

        $this->timers[$id] = (new Timer($name, microtime(true), $message))
                                    ->setMonolog($this->getMonolog());

        return $id;
    }

    /**
     * Calculate timed taken for a process to complete.
     *
     * @param  \Laravie\Profiler\Timer|string|null  $name
     *
     * @return void
     */
    public function timeEnd($name = null)
    {
        $timer = $name instanceof Timer ? $name : $this->resolveTimerFromName($name);

        $timer->end();
    }

    /**
     * Resolve timer from name.
     *
     * @param  string|null $name
     *
     * @return \Laravie\Profiler\Timer
     */
    protected function resolveTimerFromName($name = null)
    {
        $id = is_null($name) ? uniqid() : $name;

        if (isset($this->timers[$id])) {
            return $this->timers[$id];
        }

        return (new Timer($name, constant('LARAVEL_START')))
                    ->setMonolog($this->getMonolog());
    }

    /**
     * Get the monolog instance.
     *
     * @return \Monolog\Logger
     */
    abstract public function getMonolog();
}
