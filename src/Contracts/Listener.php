<?php

namespace Laravie\Profiler\Contracts;

use Illuminate\Log\LogManager;

interface Listener
{
    /**
     * Handle the listener.
     *
     * @param  \Illuminate\Log\LogManager  $logger
     *
     * @return void
     */
    public function handle(LogManager $logger): void;
}
