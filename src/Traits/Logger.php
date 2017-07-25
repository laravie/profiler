<?php

namespace Laravie\Profiler\Traits;

use Monolog\Logger as Monolog;

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
    public function setMonolog(Monolog $monolog)
    {
        $this->monolog = $monolog;

        return $this;
    }
}
