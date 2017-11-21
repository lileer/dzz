<?php
/**
 * 模型过滤器
 *
 * PHP Version 5
 *
 * @package   Mapper
 * @author    Weber Liu <weber.liu@gmail.com>
 * @copyright 2010 Xingchangxinda Inc.
 * @version   SVN:$Id: filter.php 36 2012-03-21 07:54:30Z blue5tar $
 */

namespace Dzz\Mapper\Mysql;

class Filter
{
    private $fields = [];
    private $conditions = [];
    private $isGoroup = false;

    public function __construct($fields = [])
    {
        if (!empty($fields)) {
            foreach ($fields as $key => $value) {
                $this->fields[] = $key;
            }
        }
    }

    private function addWhere($operator, $fieldName, $compare, $value)
    {
        $compare = strtoupper($compare);
        $allowed = array('=', '>=', '<=', '>', '<', '<>', 'IN', 'LIKE', 'NOT IN', 'BETWEEN');

        if (!in_array($compare, $allowed)) {
            throw new \Exception('不支持的比较运算：');
        }

        if (is_array($value)) {
            foreach ($value AS $key => $val) {
                $value[$key] = addslashes($val);
            }
        } else {
            $value = addslashes($value);
        }

        switch ($compare) {
            case 'IN':
                if (!is_array($value)) {
                    throw new \Exception('用于 IN 比较的必须是数组');
                }
                $value = "('" . implode("','", $value) . "')";
                break;
            case 'NOT IN':
                if (!is_array($value)) {
                    throw new \Exception('用于 IN 比较的必须是数组');
                }
                $value = "('" . implode("','", $value) . "')";
                break;
            case 'BETWEEN':
                if (!is_array($value) || count($value) != 2) {
                    throw new \Exception('用于 BETWEEN 比较的必须是数组');
                }
                $value = "'{$value[0]}' AND '{$value[1]}'";
                break;
            default:
                $value = "'" . $value . "'";
                break;
        }
        if (empty($this->conditions)) {
            $operator = '';
        }
        $cell = [$operator, $fieldName, $compare, $value];
        if ($this->isGoroup) {
            $end = end($this->conditions);
            if (isset($end['AND']) ) {
                $this->conditions[count($this->conditions) - 1]['AND'][] = $cell;
            } elseif (isset($end['OR'])) {
                $this->conditions[count($this->conditions) - 1]['OR'][] = $cell;
            }
        } else {
            $this->conditions[] = $cell;
        }
    }

    public function getConditions()
    {
        return $this->conditions;
    }


    public function where()
    {
        $args = func_get_args();
        if (count($args) == 3) {
            $field = $args[0];
            $compare = $args[1];
            $val = $args[2];
            $this->addWhere('AND', $field, $compare, $val);
        } elseif (count($args) == 1 && $args[0] instanceof \Closure) {
            $this->isGoroup = true;
            $this->conditions[] = ['AND' => []];
            $args[0]($this);
            $this->isGoroup = false;
        }

        return $this;
    }


    public function orWhere()
    {
        $args = func_get_args();
        if (count($args) == 3) {
            $field = $args[0];
            $compare = $args[1];
            $val = $args[2];
            $this->addWhere('OR', $field, $compare, $val);
        } elseif (count($args) == 1 && $args[0] instanceof \Closure) {
            $this->isGoroup = true;
            $this->conditions[] = ['OR' => []];
            $args[0]($this);
            $this->isGoroup = false;
        }

        return $this;
    }


}

