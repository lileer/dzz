<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/10/18
 * Time: 下午6:09
 */

namespace dzz\Core\Router;

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

            var_dump($this->segments);

        }
    }
}