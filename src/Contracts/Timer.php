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
    public function end(callable $callback = null);

    /**
     * End the timer if condition is matched.
     *
     * @param  bool  $condition
     *
     * @return void
     */
    public function endIf(bool $condition);

    /**
     * End the timer unless condition is matched.
     *
     * @param  bool  $condition
     *
     * @return void
     */
    public function endUnless(bool $condition);

    /**
     * Get or replace context.
     *
     * @param  array|null  $context
     *
     * @return $this|array
     */
    public function context(array $context = []);

    /**
     * Get or replace message.
     *
     * @param  string|null  $message
     *
     * @return $this|string
     */
    public function message(string $message = null);

    /**
     * Get or replace name.
     *
     * @param  string|null  $name
     *
     * @return $this|string
     */
    public function name(string $name = null);

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
