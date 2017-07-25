<?php

namespace Laravie\Profiler\Events;

use Monolog\Logger;
use Illuminate\Http\Request;
use Laravie\Profiler\Contracts\Listener;

class Request implements Listener
{
    /**
     * Handle the listener.
     *
     * @param  \Monolog\Logger  $monolog
     * @return void
     */
    public function handle(Logger $monolog)
    {
        $monolog->addInfo('<info>Request: '.$this->getCurrentRoute().'</info>');
    }

        /**
     * Get current route.
     *
     * @return string
     */
    protected function getCurrentRoute()
    {
        $request = app(Request::class);
        $method  = strtoupper($request->getMethod());
        $path    = ltrim($request->path(), '/');
        $host    = $request->getHost();

        ! is_null($host) && $host = rtrim($host, '/');

        return "{$method} {$host}/{$path}";
    }
}
