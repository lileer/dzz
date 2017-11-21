<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/10/19
 * Time: 上午9:46
 */

namespace dzz\Core\Router;

use Dzz\Core\Dzz;

class Factory
{

    public static function make()
    {
        $uriStyle = Dzz::$app->config['uri_style'];
        switch ($uriStyle) {
            case 'normal':
                return NormalRouter::get();
                break;
            case 'restful':
                return RestRouter::get();
                break;
            case 'cli':
                return CliRouter::get();
                break;
            default:
                throw new \Exception('Not find uri style');
        }
    }
}