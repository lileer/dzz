<?php

namespace Dzz\Cli;

use \Dzz\Core\App as BaseApp;

class App extends BaseApp
{

    const DEFAULT_ACTION = 'execute';

    public $appName = '';

    public $nameSpace;

    /**
     * 找不到指定的任务
     *
     * @author Garbin
     * @return void
     */
    protected static function notFound()
    {
        echo '找不到指定的任务';
    }

    /**
     * 获得调用的控制器以及调用的方法
     *
     * @return array
     * @author weber liu
     */
    protected function called()
    {
        $req = Request::get();
        $job = $req->get('job', 'string', 'DefaultJob');
        $action = $req->get('action', 'string', self::DEFAULT_ACTION);

        $jobClass = $this->nameSpace . '\\Jobs\\' . $job;
        if (is_callable($jobClass . '::' . $action)) {
            return array($jobClass, $action);
        } else {
            return false;
        }
    }

    /**
     * 获取应用程序实例
     *
     * @return object
     * @author Weber Liu
     * @author Scott Ye
     */
    final static function getInstance()
    {
        static $obj = null;

        if (null === $obj) {
            $req = Request::get();
            $app = ucfirst($req->get('app'));
            $ns = '\\Project\\Apps\\' . $app;
            $cls = $ns . '\\CLIApplication';
            $obj = new $cls($app);
            $obj->ns = $ns;
        }

        return $obj;
    }

    /**
     * 根据当前的请求执行应用程序相应的控制器
     *
     * @return void
     * @author Weber Liu
     */
    public function run()
    {
        $request = \Framework\System\Helper\CLIRequest::getInstance();

        $call    = self::called();

        /**
         * 如果没有找到对应的控制器和方法则返回404
         */
        if ($call === false) {
            self::notFound();
            return;
        }

        call_user_func_array("{$call[0]}::{$call[1]}", array($request, null));
    }

    /**
     * 获取当前应用程序的Namespace
     *
     * @return string
     * @author anders
     */
    public function getNamespace()
    {
        $ref = new \ReflectionClass($this);
        return $ref->getNameSpaceName();
    }
}