<?php

namespace Laravie\Profiler\Contracts;

interface Timing
{
    /**
     * Time a process.
     *
     * @param  string       $name
     * @param  string|null  $message
     *
     * @return string
     */
    public function time($name, $message = null);

    /**
     * Calculate timed taken for a process to complete.
     *
     * @param  string|null  $name
     *
     * @return void
     */
    public function timeEnd($name = null);
}
