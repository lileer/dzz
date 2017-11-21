<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/30
 * Time: 下午7:43
 */

namespace dzz\Mapper\Redis;

use Dzz\Mapper\BaseConnection;

class Connection extends BaseConnection
{
    protected static $writerCon;
    protected static $readrCon;
    
    public static function get($isWrite = false)
    {
        $config = \Dzz\Core\Dzz::$app->config['redis'];
        if ($isWrite) {
            if (self::$writerCon) {
                return self::$writerCon;
            }
            $conConfig = $config['master'];
        } else {
            if (self::$readrCon) {
                return self::$readrCon;
            }
            $conConfig = self::slave($config['slave']);
        }

        $host = $conConfig['host'];
        $port = $conConfig['port'];
        try {
            $redis = new \Redis();
            $redis->connect($host, $port);

            if ($isWrite) {
                return self::$writerCon = $redis;
            }
            return self::$readrCon = $redis;
        } catch (\RedisException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}