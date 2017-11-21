<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/15
 * Time: 下午4:08
 */

namespace Dzz\ServicesProvider;


use Dzz\Core\Dzz;
use Dzz\Core\Router\RestRouter;
use Dzz\Http\Request;
use Dzz\Http\Response;

class DzzServicesProvider implements ServicesProviderInterface
{

    public function register(\Dzz\Container\Container $container)
    {

        if (!$container['request']) {
            $container['request'] = function ($container) {
                return Request::get($container);
            };
        }

        if (!$container['response']) {
            $container['response'] = function ($container) {
                return Response::get($container);
            };
        }

        if (!$container['router']) {
            $container['router'] = function ($container) {
                if (Dzz::$app->config['uri_style'] == 'restful') {
                    return RestRouter::get($container);
                }
            };
        }


    }
}