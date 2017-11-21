<?php

namespace Laravie\Profiler\Contracts;

interface Timing
{
    /**
     * Time a process.
     *
     * @param  string  $name
     * @param  string|null  $message
     *
     * @return \Laravie\Profiler\Contracts\Timer
     */
    public function time(string $name, string $message = null): Timer;

    /**
     * Calculate timed taken for a process to complete.
     *
     * @param  \Laravie\Profiler\Timer|string|null  $name
     *
     * @return void
     */
    public function timeEnd($name = null);
}
