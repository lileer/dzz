<?php

namespace Api\Controllers\Go;

class One extends \Api\Core\ApiController
{

    public static function index($params)
    {
        var_dump($params);
        var_dump(__METHOD__);
    }
	//
}
