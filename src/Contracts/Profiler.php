<?php

namespace Laravie\Profiler\Contracts;

interface Profiler extends Timing
{
    /**
     * Extend the profiler.
     *
     * @param  \Laravie\Profiler\Contracts\Listener  $listener
     *
     * @return $this
     */
    public function extend(Listener $listener);
}
