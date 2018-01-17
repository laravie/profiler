<?php

namespace Laravie\Profiler\Traits;

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
     * @return \Monolog\Logger
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
    public function setLogger(LogManager $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
