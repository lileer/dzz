<?php

return [
    [
        'method' => 'get',
        'pattern' =>'/products/{id}',
        'action' => Api\Controllers\Products::class . '::index'
    ]
];


