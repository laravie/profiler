<?php

namespace Laravie\Profiler\Contracts;

use Monolog\Logger;

interface Listener
{
    /**
     * Handle the listener.
     *
     * @param  \Monolog\Logger  $monolog
     *
     * @return void
     */
    public function handle(Logger $monolog);
}
