<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/8
 * Time: 下午1:54
 */

return [
    'master' => [
        'user' => 'root',
        'password' => 'hangcom',
        'dbms' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'dzztest'
    ],
    'slave' => [
        ['weigth' => 3, 'user' => 'root', 'password' => 'hangcom', 'dbms' => 'mysql', 'host' => 'localhost', 'dbname' => 'dzztest'],
        ['weigth' => 7, 'user' => 'root', 'password' => 'hangcom', 'dbms' => 'mysql', 'host' => 'localhost', 'dbname' => 'dzztest'],
        ['weigth' => 1, 'user' => 'root', 'password' => 'hangcom', 'dbms' => 'mysql', 'host' => 'localhost', 'dbname' => 'dzztest']
    ]
];