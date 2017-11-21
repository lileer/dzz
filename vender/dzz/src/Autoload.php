<?php

class Autoload
{

    public static function register($global)
    {
        spl_autoload_register(function ($className) use ($global) {
            $className = ltrim($className, '\\');
            if (strtolower(substr($className, 0, strlen($global['appid']))) == $global['appid']) { //app
                $className = substr($className, strlen($global['appid']));

                self::includeFile(APPPATH, $className);
            } elseif (substr($className, 0, 6) == 'Common') { //common
                self::includeFile(dirname(APPPATH) . DIRECTORY_SEPARATOR, strtolower($className));
            } else { //dzz framework
                $className = substr($className, 3);
                self::includeFile(DZZSRC, $className);
            }
        });
    }

    public static function includeFile($dir, $className)
    {
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $namespace = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            $className = substr($className, $lastNsPos + 1);
        }
        $fileName = $dir . $namespace . $className . '.php';

        if (file_exists($fileName)) {
            require $fileName;
            return true;
        }

    }
}
Autoload::register($global);