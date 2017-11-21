<?php

namespace Dzz\Mapper;

abstract class BaseConnection
{

    protected static function slave($data)
    {
        $result = [];
        $arr = [];
        foreach ($data as $key => $val) {
            $arr[] = $val['weigth'];
        }
        $proSum = array_sum($arr);
        asort($arr);
        foreach ($arr as $k => $v) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $v) {
                $result = $data[$k];
                break;
            } else {
                $proSum -= $v;
            }
        }
        return $result;
    }




}