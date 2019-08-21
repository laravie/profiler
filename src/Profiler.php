<?php

namespace Laravie\Profiler;

use Psr\Log\AbstractLogger;
use Illuminate\Log\LogManager;

class Profiler extends AbstractLogger implements Contracts\Profiler
{
    use Concerns\Logger,
        Concerns\Timing;

    /**
     * Setup a new profiler.
     *
     * @param \Illuminate\Log\LogManager $logger
     */
    public function __construct(LogManager $logger)
    {
        $this->setLogger($logger);
    }

    /**
     * Extend the profiler.
     *
     * @param  \Laravie\Profiler\Contracts\Listener  $callback
     *
     * @return $this
     */
    public function extend(Contracts\Listener $listener)
    {
        $listener->handle($this->getLogger());

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
    public function log($level, $message, array $context = [])
    {
        $this->getLogger()->log($level, $message, $context);
    }
}
