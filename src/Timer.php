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
     * Timer context.
     *
     * @var array
     */
    protected $context = [];

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
     * @param int|float  $startedAt
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
        $message = $this->message();

        $this->getMonolog()->addInfo($message, $this->context);

        if (is_callable($callback)) {
            call_user_func($callback, [
                'name' => $this->name,
                'message' => $message,
                'startedAt' => $this->startedAt,
                'lapse' => $this->lapse(),
                'context' => $this->context,
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
        if ((bool) $condition) {
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
     * Get or replace context.
     *
     * @param  array|null  $context
     *
     * @return $this|array
     */
    public function context(array $context = null)
    {
        if (! is_null($context)) {
            $this->context = $context;

            return $this;
        }

        return $this->context;
    }

    /**
     * Get or replace message.
     *
     * @param  string|null  $message
     *
     * @return $this|string
     */
    public function message(string $message = null)
    {
        if (! is_null($message)) {
            $this->message = $message;

            return $this;
        }

        $message = $this->message ?: '{name} took {lapse} seconds.';

        return Str::replace($message, [
            'name' => $this->name,
            'started' => $this->startedAt,
            'lapse' => $this->lapse(),
        ]);
    }

    /**
     * Get or replace name.
     *
     * @param  string|null  $name
     *
     * @return $this|string
     */
    public function name(string $name = null)
    {
        if (! is_null($name)) {
            $this->name = $name;

            return $this;
        }

        return $this->name;
    }

    /**
     * Get started at.
     *
     * @return int|float
     */
    public function startedAt()
    {
        return $this->startedAt;
    }

    /**
     * Get seconds.
     *
     * @return int|float
     */
    public function lapse()
    {
        $endedAt = microtime(true);

        return $endedAt - $this->startedAt;
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
