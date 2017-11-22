<?php

namespace Dzz\Core\Router;

use Dzz\Core\Dzz;

class NormalRouter extends Router
{

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
            $current = APPPATH . 'Controllers/';
            foreach ($this->segments as $k => $v) {
                if (is_dir($current . ucfirst($v))) {
                    $current .=  ucfirst($v) . '/';
                    continue;
                } elseif (is_file($current . ucfirst($v) . '.php')) {
                    $params = [];
                    $appId = Dzz::$app->config['appid'];
                    $current = str_replace(APPPATH, '', $current);
                    $action = ucfirst($appId) . '\\' . str_replace('/', '\\', $current) . ucfirst($v);
                    if (count($this->segments) == $k + 1 && $this->defaultMethod) {
                        $method = $this->defaultMethod;
                    } elseif (!is_numeric($this->segments[$k + 1])) {
                        $method = $this->segments[$k + 1];
                        $params = array_slice($this->segments, $k + 2);
                    } else {
                        throw new \Exception('Method is not find');
                    }
                    $action .= '::' . $method;
                    return $callback($action, $params);
                }
            }

        }
    }
}