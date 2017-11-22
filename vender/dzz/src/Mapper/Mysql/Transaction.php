<?php

namespace dzz\Mapper\Mysql;


class Transaction
{

    public static function con()
    {
        return Connection::get();
    }

    public static function begin()
    {
        self::con()->beginTransaction();
    }

    public static function commit()
    {
        self::con()->commit();
    }

    public static function rollBack()
    {
        self::con()->rollBack();
    }

    public static function run($callback)
    {
        if (is_callable($callback)) {
            self::begin();
            try {
                $callback();
                self::commit();
            } catch (\Exception $e) {
                self::rollBack();
                throw new \Exception($e->getMessage(), $e->getCode());
            }
        } else {
            throw new \Exception('is no callback');
        }

    }

}