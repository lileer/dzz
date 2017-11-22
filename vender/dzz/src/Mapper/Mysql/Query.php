<?php

namespace Dzz\Mapper\Mysql;

use Dzz\Mapper\Model;
use Dzz\Mapper\DataSet;
use Dzz\Mapper\QueryDelegate;

class Query
{

    private $filter;
    private $queryFields;
    public $model;
    private $orderBy;
    private $groupBy;
    private $joinFields = [];
    private $distinct = false;
    private $calcRows = false;
    private $lastQuery = false;
    protected $queryData;

    public function __construct($model, Filter $filter = null)
    {
        $this->model = $model;
        $this->filter = $filter;
    }

    public function setData($data)
    {
        $this->queryData = $data;
        return $this;
    }

    public function __call($func, $arguments)
    {
        if ($this->filter === null) {
            $this->filter = $this->model->filter();
        }
        if (! is_callable(array($this->filter, $func))) {
            throw new \Exception("{$func} 不是一个有效的方法。");
        }
        call_user_func_array(array($this->filter, $func), $arguments);

        return $this;
    }


    public function one($isArr = false)
    {
        $sql = $this->buildQuery(1);

        try {
            $res = Connection::get()->query($sql)->fetchAll();
        } catch (\Exception $e) {
            throw new \Exception('查询数据库失败: ' . $sql);
        }

        if (!$isArr) {
            $model = $this->model->modelName;
            if (count($res) === 0) {
                return null;
            } else {
                return $model::create()->setAttributes($res[0], true);
            }
        } else {
            return (count($res) === 0) ? [] : $res[0];
        }
    }

    public function all($num = 0, $start = 0, $isArr = false)
    {
        try {
            $sql = $this->buildQuery($num, $start);
            $res = Connection::get()->query($sql)->fetchAll();
        } catch (\Exception $e) {
            throw new \Exception('查询数据库失败: ' . $sql);
        }

        if ($isArr) {
            return $res;
        } else {
            if (empty($this->queryFields)) {
                $model = $this->model->modelName;
                $objects = [];
                foreach ($res as $key => $value) {
                    $obj = $model::create()->setAttributes($value, true);
                    $objects[$value[Model::PRIMARY_KEY]] = $obj;
                }
                return new DataSet($objects);
            } else {
                return new DataSet($res);
            }
        }
    }

    public function kall()
    {
        return QueryDelegate::kall($this);
    }

    public function kone()
    {
        return QueryDelegate::kone($this);
    }

    public function count()
    {
        $tableName  = $this->model->tableName;
        $where      = $this->where();
        $joins      = $this->getJoin();

        $this->lastQuery = "SELECT COUNT(*) \nFROM $tableName \n $joins \n$where";
        $res = Connection::get()->query($this->lastQuery)->fetchAll();
        return $res[0][0];
    }


    public function insert()
    {
        if (empty($this->queryData)) {
            throw new \Exception("没有设置任何插入的数据。");
        }

        $tbl = $this->model->tableName;
        $sql = "INSERT INTO $tbl (%s) VALUES (%s)";
        $cols = [];
        $cols2 = [];
        $params = [];
        foreach ($this->queryData as $key => $value) {
            $cols[] = '`' . $key . '`';
            $cols2[] =  ':' . $key;
            $params[':' . $key] = $value;
        }
        $sql = sprintf($sql, implode(',', $cols), implode(',', $cols2));
        try {
            $conn = Connection::get(true);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        } catch (\Exception $e) {
            throw new \Exception("执行 Insert 操作时出错." . $e->getMessage());
        }

        return  $conn->lastInsertId();
    }


    public function update()
    {
        if (empty($this->queryData)) {
            throw new \Exception("没有设置任何更新的数据。");
        }
        $tbl = $this->model->tableName;
        $values = [];
        $params = [];
        foreach ($this->queryData as $key => $value) {
            $values[] = '`' . $key . "` = " . ':' . $key;
            $params[':' . $key] = $value;
        }
        $sql = "UPDATE $tbl SET " . implode(',', $values) . $this->where();
        try {
            $stmt = Connection::get(true)->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (\Exception $e) {
            throw new \Exception("执行 Update 操作时出错" . $e->getMessage());
        }

    }

    public function delete($num = 0)
    {
        if ($this->filter === null) {
            throw new \Exception("必须指定一个删除的过滤条件。");
        }
        $where = $this->where();
        $tbl = $this->model->tableName;
        $limit = ($num === 0) ? '' : "LIMIT $num";
        $sql = "DELETE FROM $tbl $where $limit";

        $stmt = Connection::get(true)->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function fields()
    {
        $args = func_get_args();
        if (count($args) === 0 || $args[0] === '*') {
            $this->queryFields = '*';
            return $this;
        } else {
            $this->queryFields = $args[0];
            return $this;
        }
    }

    private function where()
    {
        return ' WHERE ' . $this->parse();
    }

    public function getParse()
    {
        return $this->parse();
    }

    public function parse()
    {
        $str = '';
        foreach ($this->filter->getConditions() as $val) {
            if (is_array($val) && count($val) == 4) {
                $str .= ' ' . $val[0] . ' ' . $val[1] . ' ' . $val[2] . ' ' . $val[3];
            } elseif (isset($val['AND']) || isset($val['OR'])) {
                if (isset($val['AND'])) {
                    $str .= ' AND (';
                    $operator = 'AND';
                } elseif (isset($val['OR'])) {
                    $str .= ' OR (';
                    $operator = 'OR';
                }
                foreach ($val[$operator] as $key => $vall) {
                    $key != 0 && $str .= ' ' . $vall[0] . ' ';
                    $str .=  $vall[1] . ' ' . $vall[2] . ' ' . $vall[3];
                }
                $str .= ')';
            }
        }
        return $str;
    }

    private function buildQuery($num = 0, $start = 0)
    {

        $tableName = $this->model->tableName;
        $fields    = $this->queryFields == null ? '*' : $this->queryFields;
        $where     = $this->where();
        $orderBy   = $this->orderBy;
        $joins     = $this->getJoin();
        $groupBy   = $this->groupBy;
        $limit     = ($num === 0 && $start === 0) ? '' : "LIMIT $start, $num";

        $this->distinct && $fields = " DISTINCT " . $fields;
        $this->calcRows && $fields = ' SQL_CALC_FOUND_ROWS ' . $fields;
        $this->lastQuery = "SELECT $fields \nFROM $tableName \n$joins \n$where \n$groupBy \n$orderBy \n$limit";

        return $this->lastQuery;
    }

    public function getQuery($num = 0, $start = 0)
    {
        return $this->buildQuery($num, $start);
    }

    public function orderBy($orderBy)
    {
        $this->orderBy = 'ORDER BY ' . $orderBy;
        return $this;
    }

    public function join($table, $relation, $type = 'LEFT')
    {
        $join = [
            'table' => $table,
            'relation' => $relation,
            'type' => $type,
        ];
        array_push($this->joinFields, $join);

        return $this;
    }

    private function getJoin()
    {
        $joins = '';
        if (!empty($this->joinFields)) {
            foreach ($this->joinFields as $val) {
                $joins .= " {$val['type']} JOIN `{$val['table']}`
                ON {$val['relation']}\n";
            }
        }

        return $joins;
    }

    public function groupBy($groupBy)
    {
        $this->groupBy = 'GROUP BY ' . $groupBy;
        return $this;
    }

    public function distinct()
    {
        $this->distinct = true;
        return $this;
    }

    public function calcRows()
    {
        $this->calcRows = true;
        return $this;
    }


}