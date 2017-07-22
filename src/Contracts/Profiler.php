<?php

namespace Laravie\Profiler\Contracts;

interface Profiler extends Timing
{
    /**
     * Extend the profiler.
     *
     * @param  callable  $callback
     *
     * @return $this
     */
    public function extend(callable $callback);
}
