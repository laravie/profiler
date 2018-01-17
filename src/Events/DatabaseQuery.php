<?php

namespace Laravie\Profiler\Events;

use Illuminate\Support\Str;
use Illuminate\Log\LogManager;
use Laravie\Profiler\Contracts\Listener;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Events\QueryExecuted;

class DatabaseQuery implements Listener
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
        $db = resolve('db');

        $callback = $this->buildQueryCallback($logger);

        foreach ($db->getQueryLog() as $query) {
            $callback(new QueryExecuted($query['query'], $query['bindings'], $query['time'], $db));
        }

        resolve(Dispatcher::class)->listen(QueryExecuted::class, $callback);
    }

    /**
     * BUild Query Callback.
     *
     * @param  \Illuminate\Log\LogManager  $logger
     *
     * @return callable
     */
    protected function buildQueryCallback(LogManager $logger): callable
    {
        return function (QueryExecuted $query) use ($logger) {
            $sql = Str::replaceArray('?', $query->connection->prepareBindings($query->bindings), $query->sql);

            $logger->info("<comment>{$sql} [{$query->time}ms]</comment>");
        };
    }
}
