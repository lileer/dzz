<?php

namespace Dzz\Core\Router;

use Dzz\Core\Dzz;
use Dzz\Http\Request;

class RestRouter extends Router
{
    public $routerConfig;

    public function __construct()
    {
        parent::__construct();

        $this->init();
    }

    protected function init()
    {
        parent::init();
        $this->routerConfig = Dzz::$app->config['router'];
    }

    public function match($callback)
    {
        if (!empty($this->segments)) {
            $i = 0;
            $params = [];
            foreach ($this->routerConfig as $val) {
                $pattern = $val['pattern'];
                $patternArray = explode('/', $pattern);
                array_shift($patternArray);
                if (Request::get()->getMethod() != strtoupper($val['method'])) {
                    continue;
                }
                foreach ($this->segments as $key => $segment) {
                    if ($segment == $patternArray[$key]) {
                        $i++;
                        continue;
                    }elseif ($patternArray[$key] == '{id}' && is_numeric($segment)) {
                        array_push($params, $segment);
                        $i++;
                        continue;
                    }
                    break;
                }
                if ($i == count($patternArray) && count($patternArray) == count($this->segments)) {
                    return $callback($val['action'], $params);
                }

                $i = 0;
            }

            if ($this->defaultAction) {
                return $callback($this->defaultAction, []);
            }

            throw new \Exception('没有匹配的url', 404);
        }
    }

//    public function dispatch()
//    {
//        parent::dispatch();
//        return $callback($val['action'], $params);
//
//    }


}