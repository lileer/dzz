<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/15
 * Time: 下午4:08
 */

namespace Dzz\ServicesProvider;


interface ServicesProviderInterface
{

    public function register(\Dzz\Container\Container $container);

}