<?php

namespace Dzz\Core;

use Dzz\Pipeline\Pipeline;
use Dzz\Http\Filter;
use Dzz\Http\Request;
use Dzz\Container\Container;
use dzz\ServicesProvider\DzzServicesProvider;

class App extends Object
{

    private static $_instance;

    public static $globalVars;

    public $router;
    public static $uri;


    public $config;
    public $uriStyle;

    public $container;



    public function __construct()
    {
        parent::__construct();

//        $this->container = new Container();
//        $this->container->register(new DzzServicesProvider());
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function run()
    {
        Pipeline::get()
            ->setPassable(Request::get())
            ->setMiddleWares($this->config['middleware'])
            ->run();
    }


    public function __clone()
    {
        trigger_error('The App is not be cloned!');
    }




}