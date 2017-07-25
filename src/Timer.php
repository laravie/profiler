<?php

namespace Laravie\Profiler;

use Orchestra\Support\Str;

class Timer
{
    /**
     * Timer unique name.
     *
     * @var string
     */
    protected $name;

    /**
     * Timer message.
     *
     * @var string|null
     */
    protected $message;

    /**
     * Microtime when the timer start ticking.
     *
     * @var int
     */
    protected $startedAt;

    /**
     * Started at resolver.
     *
     * @var callable
     */
    protected $startedAtResolver;

    /**
     * Construct new timer.
     *
     * @param string  $name
     * @param int  $startedAt
     * @param string|null  $message
     */
    public function __construct($name, $startedAt, $message = null)
    {
        $this->name = $name;
        $this->startedAt = $startedAt;
        $this->message = $message;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function message()
    {
        $message = $this->message ?: '{name} took {seconds} seconds.';

        return Str::replace($message, ['name' => $this->name(), 'seconds' => $this->seconds()]);
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get seconds.
     *
     * @return int
     */
    public function seconds()
    {
        $end = microtime(true);

        return ($end - $this->start);
    }
}
