<?php

namespace Dzz\Core;

use Dzz\Http\Response;

class ErrorHandler extends Object
{

    public $message;
    public $format;

    public function register()
    {
        ini_set('display_errors', true);
        set_error_handler([$this,'handleError']);
        set_exception_handler([$this,'handleException']);
    }

    public function handleError($errno, $errstr ,$errfile, $errline)
    {
        switch ($errno) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
                echo "  Fatal error on line $errline in file $errfile";
                break;
            case E_USER_WARNING:
                echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
                break;
            case E_USER_NOTICE:
                echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
                break;
            default:
                echo "<b>Unknown error type</b> [$errno] $errstr<br />\n";
                echo "  Error on line $errline in file $errfile";

                break;
        }
        echo '<br />';
    }


    public function handleException(\Exception $e)
    {
        if (Dzz::$app->config['debug'] && Dzz::$app->config['format'] == Response::FORMAT_JSON) {
            $output['code'] = $e->getCode();
            $output['msg'] = $e->getMessage();
            $output['data']['file'] = $e->getFile();
            $output['data']['line'] = $e->getLine();
            foreach ($e->getTrace() as $key => $val) {
                $output['data']['trace'][] = $e->getTrace();
            }
        } elseif (Dzz::$app->config['debug'] && Dzz::$app->config['format'] == Response::FORMAT_HTML) {
            $trace = explode("\n", $e->getTraceAsString());
            $traceStr = '';
            foreach ($trace as $val) {
                $traceStr .= "<span style='background-color: #ccc;display: block;margin-bottom: -20px;'>" . $val . '</span><br>';
            }
            $output = <<<EOT
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title></title>
            </head>
            <body>
            <div>msg:{$e->getMessage()} <br></div>
            code:{$e->getCode()} <br>
            file:{$e->getFile()} <br>
            line:{$e->getLine()} <br>
            trace:<br>{$traceStr} <br>
            </body>
            </html>
EOT;
        }
        Response::get($output)->output();
    }

}