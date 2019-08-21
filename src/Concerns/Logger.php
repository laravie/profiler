<?php

namespace Laravie\Profiler\Concerns;

use Illuminate\Log\LogManager;

trait Logger
{
    /**
     * Monolog instance.
     *
     * @var \Illuminate\Log\LogManager
     */
    protected $logger;

    /**
     * Get log manager instance.
     *
     * @return \Illuminate\Log\LogManager
     */
    public function getLogger(): LogManager
    {
        return $this->logger;
    }

    /**
     * Set log manager instance.
     *
     * @param  \Illuminate\Log\LogManager  $logger
     *
     * @return $this
     */
    public function setLogger(LogManager $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}
