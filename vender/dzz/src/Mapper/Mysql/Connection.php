<?php

namespace Dzz\Mapper\Mysql;

use Dzz\Mapper\BaseConnection;

class Connection extends BaseConnection
{
    protected static $writeCon;
    protected static $readCon;

    public static function get($isWrite = false)
    {
        $config = \Dzz\Core\Dzz::$app->config['database'];
        if ($isWrite) {
            if (self::$writeCon) {
                return self::$writeCon;
            }
            $conConfig = $config['master'];
        } else {
            if (self::$readCon) {
                return self::$readCon;
            }
            $conConfig = self::slave($config['slave']);
        }

        $user = $conConfig['user'];
        $password = $conConfig['password'];
        $dbms = $conConfig['dbms'];
        $host = $conConfig['host'];
        $dbName = $conConfig['dbname'];
        $dsn = "$dbms:host=$host;dbname=$dbName";
        try {
            $tmpCon = new \PDO($dsn, $user, $password, [\PDO::ATTR_PERSISTENT => true, \PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES utf8']);
            $tmpCon->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            if ($isWrite) {
                return self::$writeCon = $tmpCon;
            }
            return self::$readCon = $tmpCon;
        } catch (\PDOException $e) {
           throw new \Exception($e->getMessage());
        }
    }




}