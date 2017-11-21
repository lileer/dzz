<?php

return [
    'middleware' => [
        Dzz\Http\Filter::class,
        Dzz\Http\Test::class,
        Common\Middleware\Auth::class
    ],
    'database' => require_once 'database.php',
    'redis' => require_once 'redis.php',
    'format' => \Dzz\Http\Response::FORMAT_HTML,
    'default_action' => \Api\Controllers\Index::class . '::index',
];