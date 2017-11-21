<?php

$GLOBALS['start_time'] = microtime();
define('APPPATH', __DIR__ . '/');
define('DZZSRC', dirname(APPPATH) . '/vender/dzz/src/');

$global = require APPPATH . 'config/global.php';

require DZZSRC . 'Autoload.php';


dzz\core\Dzz::init($global)->run();
