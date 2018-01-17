<?php

namespace Laravie\Profiler;

use Monolog\Logger;
use Psr\Log\AbstractLogger;

class Profiler extends AbstractLogger implements Contracts\Profiler
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

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $this->getMonolog()->log($level, $message, $context);
    }
}
