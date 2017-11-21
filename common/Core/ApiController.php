<?php

namespace common\Core;

use common\entity\User;

class ApiController extends \dzz\core\Controller
{


    public function __construct()
    {
    }

    public static function check()
    {
            User::get()->userId;
    }


}