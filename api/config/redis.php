<?php

return [
    'master' => [
        'host' => 'localhost',
        'port' => 6379,
        'timeout' => 0,
    ],
    'slave' => [
        ['weigth' => 1, 'host' => 'localhost', 'port' => 6379, 'timeout' => 0],
        ['weigth' => 1, 'host' => 'localhost', 'port' => 6379, 'timeout' => 0],
        ['weigth' => 2, 'host' => 'localhost', 'port' => 6379, 'timeout' => 0],
    ]
];