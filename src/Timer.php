<?php

namespace Laravie\Profiler;

use Orchestra\Support\Str;

class Timer
{
    use Traits\Logger;

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
     * End the timer.
     *
     * @param  callable|null  $callback
     *
     * @return void
     */
    public function end(callable $callback = null)
    {
        $this->getMonolog()->addInfo($this->message());

        if (is_callable($callback)) {
            call_user_func($callback, [
                'name' => $this->name,
                'message' => $this->message(),
                'seconds' => $this->lapse(),
            ]);
        }
    }

    /**
     * End the timer if condition is matched.
     *
     * @param  bool  $condition
     *
     * @return void
     */
    public function endIf($condition)
    {
        if ($condition !== true) {
            $this->end();
        }
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function message()
    {
        $message = $this->message ?: '{name} took {seconds} seconds.';

        return Str::replace($message, ['name' => $this->name, 'seconds' => $this->lapse()]);
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
     * Get started at.
     *
     * @return int
     */
    public function startedAt()
    {
        return $this->startedAt;
    }

    /**
     * Get seconds.
     *
     * @return int
     */
    public function lapse()
    {
        $endedAt = microtime(true);

        return ($endedAt - $this->startedAt);
    }
}
