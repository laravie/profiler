<?php

namespace Laravie\Profiler\Events;

use Monolog\Logger;
use Illuminate\Support\Str;
use Laravie\Profiler\Contracts\Listener;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Events\QueryExecuted;

class DatabaseQuery implements Listener
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
        $db = resolve('db');

        $callback = $this->buildQueryCallback($monolog);

        foreach ($db->getQueryLog() as $query) {
            $callback(new QueryExecuted($query['query'], $query['bindings'], $query['time'], $db));
        }

        resolve(Dispatcher::class)->listen(QueryExecuted::class, $callback);
    }

    /**
     * BUild Query Callback.
     *
     * @param  \Monolog\Logger  $monolog
     *
     * @return \Closure
     */
    protected function buildQueryCallback(Logger $monolog)
    {
        return function (QueryExecuted $query) use ($monolog) {
            $sql = Str::replaceArray('?', $query->connection->prepareBindings($query->bindings), $query->sql);

            $monolog->addInfo("<comment>{$sql} [{$query->time}ms]</comment>");
        };
    }
}
