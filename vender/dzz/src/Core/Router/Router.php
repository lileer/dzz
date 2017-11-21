<?php

namespace Dzz\Core\Router;

use Dzz\Core\Dzz;
use Dzz\Http\Uri;
use Dzz\Core\Object;

class Router extends Object
{

    public $routerConfig;

    protected $segments;
    protected $defaultAction;
    protected $params;

    public function __construct()
    {
        parent::__construct();
    }

    protected function init()
    {
        $this->setSegment();
        $this->defaultAction = Dzz::$app->config['default_action'];
    }

    private function setSegment()
    {
        $this->segments = Uri::get()->parse()->getSegments();
    }

    public function match($callback)
    {
    }


    public function dispatch()
    {

    }



}