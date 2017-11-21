<?php

namespace Laravie\Profiler;

use Monolog\Logger;

class Profiler implements Contracts\Profiler
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
     * @param  \Laravie\Profiler\Contracts\Listener  $callback
     *
     * @return $this
     */
    public function extend(Contracts\Listener $listener): self
    {
        $listener->handle($this->getMonolog());

        return $this;
    }
}
