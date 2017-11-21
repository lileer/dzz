<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/9
 * Time: 下午1:33
 */

namespace Dzz\Http;

use dzz\Container\Container;
use Dzz\Core\App as BaseApp;
use dzz\Core\DispatchManager;
use Dzz\Core\Dzz;
use Dzz\Core\ErrorHandler;
use Dzz\Core\Instances;
use dzz\Core\Router\Factory;
use dzz\Core\Router\NormalRouter;
use Dzz\core\Router\RestRouter;
use Dzz\Mapper\Model;
use Dzz\Pipeline\Pipeline;
use Dzz\Core\Router\Factory as RouterFactory;


class App extends BaseApp
{

    private $request;
    private $response;
    private $session;

    public $ex;

    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        parent::run();

//        $data = [
//            'post_id' => 1000,
//            'title' => 'dddd',
//            'icon' => 'http://getarts.b0.upaiyun.com/2015/08/12/143935689909085500.jpg',
//            'created' => time(),
//            'type' => 2
//            ];
//
////        var_dump(Model::query()->setData($data)->insert());
//        $filter = new \Dzz\Mapper\Filter();
//        $filter->where('members.id', '<', 5);
////        $data = ['title' => '大登陆上开发及d'];
////        Model::query($filter)->setData($data)->update();
////        var_dump(Model::query($filter)->delete());
//        $dataSet = Model::query($filter)
//            ->fields('*')
//            ->join('members_life', 'members.id=members_life.userid')
//            ->groupBy('members.id')
//            ->orderBy('members.id asc')
//            ->all();
//        var_dump($dataSet);
//        exit;

//        $this->test2();



//        DispatchManager::bind($pipe, function ($class, $params) {
//            $this->
//            return call_user_func_array($class, $params);
//        });

        Response::get(RouterFactory::make()->match(function ($class, $params) {
            return call_user_func_array($class, $params);
        }))->output();


    }

//    public function test2()
//    {
//        $container = new \Dzz\Container\Container();
//        $container->set('db', \Dzz\Mapper\Connection::class);
//        $con = $container->get('db');
//        $con->connect();
//        $sql = 'select * from works_type';
//
//        foreach ($con->con->query($sql) as $row) {
//            print $row['id'] . "\t";
//            print $row['type'] . "\t";
//            print $row['pic'] . "\n";
//        }
//    }
//
//    public function test()
//    {
//
//        $container = new \Dzz\Container\Container();
//
//        $container->set('aa', \Dzz\Http\Test\Aa::class, [
//            \Dzz\Http\Test\TestInterface::class => \Dzz\Http\Test\Test::class,
//            \Dzz\Http\Test\Test2Interface::class => \Dzz\Http\Test\Test2::class,
//        ]);
//        $aa =  $container->get('aa');
//       $aa->run();
//    }

}