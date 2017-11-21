<?php

namespace Dzz\Cli;

use Dzz\Core\Object;

class Request extends Object
{
    private $vars = [];

    public function __construct()
    {
        if ($GLOBALS['argc'] > 1) {
            $argv = $GLOBALS['argv'];
            unset($argv[0]);
            foreach ($argv as $key => $arg) {
                if (substr($arg, 0, 2) == '--') {
                    list($key, $val) = explode('=', $arg, 2);
                    $this->vars[substr($key, 2)] = $val;
                } else {
                    $this->vars[] = $arg;
                }
            }
        }
    }

    public function var($name, $dataType = 'string', $default = null)
    {
        $vars = $this->vars;
        switch ($dataType) {
            case 'string':
                null === $default && $default = '';
                $reval = (isset($vars[$name])) ? (string)$vars[$name] : $default;
                break;
            case 'int':
            case 'integer':
                null === $default && $default = 0;
                $reval = (isset($vars[$name])) ? intval($vars[$name]) : $default;
                break;
            case 'float':
            case 'double':
                null === $default && $default = 0.00;
                $reval = (isset($vars[$name])) ? floatval($vars[$name]) : $default;
                break;
            case 'array':
                null === $default && $default = array();
                $reval = (isset($vars[$name]) && is_array($vars[$name])) ? $vars[$name] : $default;
                break;
            case 'bool':
                null === $default && $default = false;
                $reval = (isset($vars[$name])) ? (bool)$vars[$name] : $default;
                break;
            case 'object':
                $reval = (isset($vars[$name]) && is_object($vars[$name])) ? $vars[$name] : $default;
                break;
            default:
                throw new \Exception(
                    '错误的数据类型。允许的值为 int, float, string, bool, array, object'
                );
                break;
        }

        return $reval;
    }
}
