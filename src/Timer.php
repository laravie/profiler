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
    public function end(?callable $callback = null): void
    {
        $message = $this->buildMessage();

        $this->getLogger()->info($message, $this->context);

        if (\is_callable($callback)) {
            \call_user_func($callback, [
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
     * @param  callable|null  $callback
     *
     * @return void
     */
    public function endIf(bool $condition, ?callable $callback = null): void
    {
        if ((bool) $condition) {
            $this->end($callback);
        }
    }

    /**
     * End the timer unless condition is matched.
     *
     * @param  bool  $condition
     * @param  callable|null  $callback
     *
     * @return void
     */
    public function endUnless(bool $condition, ?callable $callback = null): void
    {
        $this->endIf(! $condition, $callback);
    }

    /**
     * Get or replace context.
     *
     * @param  array  $context
     *
     * @return $this
     */
    public function context(array $context): self
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get or replace message.
     *
     * @param  string  $message
     *
     * @return $this
     */
    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get or replace name.
     *
     * @param  string  $name
     *
     * @return $this
     */
    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get seconds.
     *
     * @return int|float
     */
    public function lapse()
    {
        $endedAt = \microtime(true);

        return $endedAt - $this->startedAt;
    }

    /**
     * Property accessor.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        if (! \property_exists($this, $key)) {
            throw new InvalidArgumentException("Property [{$key}] doesn't exist!");
        }

        $build = 'build'.Str::studly($key);

        if (\method_exists($this, $build)) {
            return $this->{$build}();
        }

        return $this->{$key};
    }

    /**
     * Return Timer name as string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Build message.
     *
     * @return string
     */
    protected function buildMessage(): string
    {
        $message = $this->message ?: '{name} took {lapse} seconds.';

        return Str::replace($message, [
            'name' => $this->name,
            'started' => $this->startedAt,
            'lapse' => $this->lapse(),
        ]);
    }
}
