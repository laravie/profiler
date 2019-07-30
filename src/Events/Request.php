<?php

namespace Laravie\Profiler\Events;

use Monolog\Logger;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Contracts\Listener;
use Illuminate\Http\Request as HttpRequest;

class Request implements Listener
{
    /**
     * Handle the listener.
     *
     * @param  \Illuminate\Log\LogManager  $logger
     *
     * @return void
     */
    public function handle(LogManager $logger): void
    {
        $logger->info('<info>Request: '.$this->getCurrentRoute().'</info>');
    }

    /**
     * Get current route.
     *
     * @return string
     */
    protected function getCurrentRoute(): string
    {
        $request = \resolve(HttpRequest::class);
        $method = \strtoupper($request->getMethod());
        $path = \ltrim($request->path(), '/');
        $host = $request->getHost();

        ! \is_null($host) && $host = \rtrim($host, '/');

        return "{$method} {$host}/{$path}";
    }
}
