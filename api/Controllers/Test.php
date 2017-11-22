<?php

namespace Api\Controllers;

use Api\Core\ApiController;

class Test extends ApiController
{

    public static function index()
    {
        var_dump(func_get_args());

    }

}