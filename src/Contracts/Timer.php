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
     * Get message.
     *
     * @return string
     */
    public function message(): string;

    /**
     * Get name.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Get started at.
     *
     * @return int|double
     */
    public function startedAt();

    /**
     * Get seconds.
     *
     * @return int|double
     */
    public function lapse();
}
