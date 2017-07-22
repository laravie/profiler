<?php

namespace Laravie\Profiler\Traits;

use Monolog\Logger;

trait Logger
{
    /**
     * Monolog instance.
     *
     * @var \Monolog\Logger
     */
    protected $monolog;

    /**
     * Get monolog instance.
     *
     * @return \Monolog\Logger
     */
    public function getMonolog()
    {
        return $this->monolog;
    }

    /**
     * Set monolog instance.
     *
     * @param  \Monolog\Logger  $monolog
     *
     * @return $this
     */
    public function setMonolog(Logger $monolog)
    {
        $this->monolog = $monolog;

        return $this;
    }
}
