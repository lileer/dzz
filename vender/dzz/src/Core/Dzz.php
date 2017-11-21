<?php

namespace Dzz\Core;

class Dzz
{

    public static $app;

    public static function init($config)
    {

        self::errorHandler();
        self::check();

        if ($config['uri_style'] == 'restful' || $config['uri_style'] == 'normal') {
            self::$app = \Dzz\Http\App::get();
        } elseif ($config['uri_style'] == 'cli') {
            self::$app = \Dzz\Cli\App::get();
        }
        self::$app->uriStyle = $config['uri_style'];
        self::$app->config = array_merge($config, self::loadConfig());

        return self::$app;
    }

    private static function check()
    {
        if (PHP_VERSION < '5.6') {
            throw new \Exception('php version is not 5.6');
        }
        if (!defined('APPPATH') || !defined('DZZSRC')) {
            throw new \Exception('Path is not defined!');
        }
    }

    public static function loadConfig()
    {
        $config = require APPPATH . '/config/config.php';
        return $config;
    }

    private static function errorHandler()
    {
        ErrorHandler::get()->register();
    }

    public static function make($type, $params = null)
    {
        return Instances::make($type, $params);
    }

}