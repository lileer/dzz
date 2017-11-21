<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/26
 * Time: 下午5:55
 */

namespace Dzz\Mapper;


class DataSet extends \ArrayIterator
{

    private $index = 0;

    public function seek($position)
    {
        $this->index = $position;
        parent::seek($position);
    }

    public function __construct(array $array = array())
    {
        if (empty($array) || !isset($array[0]['id'])) {
            parent::__construct($array);
        } else {
            $arr = array();
            foreach ($array as $key => $value) {
                $arr[$value['id']] = $value;
            }

            parent::__construct($arr);
        }
    }

    public function __get($name)
    {
        if ('index' === $name) {
            return $this->index;
        }
    }

    public function next()
    {
        $this->index ++;
        parent::next();
    }

    public function rewind()
    {
        $this->index = 0;
        parent::rewind();
    }

    public function isLast()
    {
        return $this->index == $this->count() - 1;
    }

    public function isEmpty()
    {
        return $this->count() == 0;
    }

    public function getFieldValues($fieldName)
    {
        $this->rewind();
        $result = array();
        while ($this->valid()) {
            $arr = $this->current();
            $key = $this->key();
            try {
                $result[$key] = $arr[$fieldName];
            } catch (\ErrorException $e) {
                throw new \Exception("结果集中不存在 {$fieldName} 字段");
            }

            $this->next();
        }

        return $result;
    }
}
