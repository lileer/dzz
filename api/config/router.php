<?php

return [
    [
        'method' => 'get',
        'pattern' =>'/users/{id}/works/{id}',
        'action' => \api\controllers\users\Works::class . '::index'
    ],
    [
        'method' => 'get',
        'pattern' =>'/users/works/{id}',
        'action' => \api\controllers\users\Works::class . '::self'
    ],
    [
        'method' => 'get',
        'pattern' =>'/users/aa/bb/{id}',
        'action' => \api\controllers\users\aa\Bb::class . '::index'
    ],
    [
        'method' => 'get',
        'pattern' =>'/products/{id}',
        'action' => Api\Controllers\Products::class . '::index'
    ]
];


