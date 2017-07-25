<?php

namespace Laravie\Profiler\Events;

use Monolog\Logger;
use Laravie\Profiler\Contracts\Listener;
use Illuminate\Http\Request as HttpRequest;

class Request implements Listener
{
    /**
     * Handle the listener.
     *
     * @param  \Monolog\Logger  $monolog
     *
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
        $request = app(HttpRequest::class);
        $method = strtoupper($request->getMethod());
        $path = ltrim($request->path(), '/');
        $host = $request->getHost();

        ! is_null($host) && $host = rtrim($host, '/');

        return "{$method} {$host}/{$path}";
    }
}
