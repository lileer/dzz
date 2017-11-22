<?php

namespace Dzz\Http;

use Dzz\Core\App as BaseApp;

use Dzz\Core\Router\Factory as RouterFactory;


class App extends BaseApp
{

//    public $ex;

    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        parent::run();

        Response::get(RouterFactory::make()->match(function ($class, $params) {
            return call_user_func_array($class, $params);
        }))->output();

    }


}