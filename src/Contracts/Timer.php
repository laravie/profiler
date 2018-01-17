<?php

namespace Laravie\Profiler\Contracts;

interface Timer
{
    /**
     * End the timer.
     *
     * @param  callable|null  $callback
     *
     * @return void
     */
    public function end(callable $callback = null): void;

    /**
     * End the timer if condition is matched.
     *
     * @param  bool  $condition
     *
     * @return void
     */
    public function endIf(bool $condition): void;

    /**
     * End the timer unless condition is matched.
     *
     * @param  bool  $condition
     *
     * @return void
     */
    public function endUnless(bool $condition): void;

    /**
     * Get or replace context.
     *
     * @param  array  $context
     *
     * @return $this
     */
    public function context(array $context);

    /**
     * Get or replace message.
     *
     * @param  string  $message
     *
     * @return $this
     */
    public function message(string $message);

    /**
     * Get or replace name.
     *
     * @param  string  $name
     *
     * @return $this
     */
    public function name(string $name);

    /**
     * Get started at.
     *
     * @return int|float
     */
    public function startedAt();

    /**
     * Get seconds.
     *
     * @return int|float
     */
    public function lapse();
}
