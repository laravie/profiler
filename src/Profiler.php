<?php

namespace Laravie\Profiler;

use Laravie\Profiler\Contracts\Profiler as ProfilerContract;

class Profiler implements ProfilerContract
{
    use Traits\Logger,
        Traits\Timing;

    /**
     * Setup a new profiler.
     *
     * @param \Monolog\Logger $monolog
     */
    public function __construct(Logger $monolog)
    {
        $this->setMonolog($monolog);
    }

    /**
     * Extend the profiler.
     *
     * @param  callable  $callback
     *
     * @return $this
     */
    public function extend(callable $callback)
    {
        call_user_func($callback, $this->getMonolog());

        return $this;
    }
}
