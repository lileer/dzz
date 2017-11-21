<?php

namespace api\controllers\users;

use common\Models\Products;

class Works
{

    public static function index($userId, $worksId)
    {
        var_dump($userId);
        var_dump($worksId);


        Products::create()->a = 'b';
//        var_dump(Products::create());


    }

    public static function self($worksId)
    {
        var_dump($worksId);
        echo __METHOD__;
    }




}