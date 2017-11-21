<?php

namespace Laravie\Profiler;

use Orchestra\Support\Str;

class Timer implements Contracts\Timer
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
     * @param int|double  $startedAt
     * @param string|null  $message
     */
    public function __construct(string $name, $startedAt, string $message = null)
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
                'startedAt' => $this->startedAt,
                'lapse' => $this->lapse(),
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
    public function endIf(bool $condition)
    {
        if (!! $condition) {
            $this->end();
        }
    }

    /**
     * End the timer unless condition is matched.
     *
     * @param  bool  $condition
     *
     * @return void
     */
    public function endUnless(bool $condition)
    {
        return $this->endIf(! $condition);
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function message(): string
    {
        $message = $this->message ?: '{name} took {lapse} seconds.';

        return Str::replace($message, [
            'name' => $this->name,
            'started' => $this->startedAt,
            'lapse' => $this->lapse(),
        ]);
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get started at.
     *
     * @return int|double
     */
    public function startedAt()
    {
        return $this->startedAt;
    }

    /**
     * Get seconds.
     *
     * @return int|double
     */
    public function lapse()
    {
        $endedAt = microtime(true);

        return ($endedAt - $this->startedAt);
    }

    /**
     * Return Timer name as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name();
    }
}
