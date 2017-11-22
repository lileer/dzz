<?php

namespace Dzz\Core;

use Dzz\Mapper\Model;
use Dzz\Mapper\QueryDelegate;

class Entity extends Object
{

    public $id = 0;

    private $attributes = [];
    public $model;

    const BEFORE_INSERT = 'onBeforeInsert';
    const BEFORE_UPDATE = 'onBeforeUpdate';
    const BEFORE_DELETE = 'onBeforeDelete';

    const AFTER_INSERT = 'onAfterInsert';
    const AFTER_UPDATE = 'onAfterUpdate';
    const AFTER_DELETE = 'onAfterDelete';

    public static $action = [
        self::BEFORE_INSERT,
        self::BEFORE_UPDATE,
        self::BEFORE_DELETE,
        self::AFTER_INSERT,
        self::AFTER_UPDATE,
        self::AFTER_DELETE,
    ];

    protected $events = [];

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __call($method, $arguments)
    {
        switch ($method) {
            case 'save':
            case 'ksave':
                $this->handleSave($method);
                break;
            case 'delete':
            case 'kdelete':
                $this->handleDelete($method, $arguments[0]);
                break;
        }
    }

    public function getAttributes()
    {
        return array_merge(['id' => $this->id], $this->attributes);
    }

    public function __get($name)
    {
        if ($this->attributes[$name]) {
            return $this->attributes[$name];
        } elseif (isset($this->model->relations[$name])) {
            static $objects = [];
            if (!isset($objects[$name][$this->id])) {
                $relation = $this->model->relations[$name];
                $modelName = $relation->modelName;
                $toField = $relation->toField;
                $myField = $relation->myField;
                if (Model::PRIMARY_KEY === $toField) {
                    $object = $modelName::entity($this->attributes[$myField]);
                } else {
                    $object = $modelName::query()
                        ->where($toField, '=', $this->attributes[$myField])
                        ->one();
                }
                $objects[$name][$this->id] = $object;
            }
            return $objects[$name][$this->id];
        } elseif (in_array($name, array_values(self::$action))) {
            if (!empty($this->events[$name]) && $this->events[$name] instanceof Event) {
                return $this->events[$name];
            }
            return $this->events[$name] = new Event;
        }
    }

    public function setAttributes($attributes)
    {
        foreach ($attributes as $key => $value) {
            is_string($key) && $this->attributes[$key] = $value;
            $key == 'id' && $this->id = $value;
        }
        return $this;
    }

    private function handleSave($type)
    {
        if ($this->id > 0) {
            isset($this->events[self::BEFORE_UPDATE]) && $this->events[self::BEFORE_UPDATE]->fire();
            $updated = QueryDelegate::$type($this);
            (isset($this->events[self::AFTER_UPDATE]) && $updated) && $this->events[self::AFTER_UPDATE]->fire();
            return $updated;
        } else {
            isset($this->events[self::BEFORE_INSERT]) && $this->events[self::BEFORE_INSERT]->fire();
            $inserted = QueryDelegate::$type($this);
            (isset($this->events[self::AFTER_INSERT]) && $inserted) && $this->events[self::AFTER_INSERT]->fire();
        }
        $this->model->clearEntityCache($this->id);

        return $this;
    }

    private function handleDelete($type, $isClearCache = true)
    {
        if ($this->id !== 0) {
            isset($this->events[self::BEFORE_DELETE]) && $this->events[self::BEFORE_DELETE]->fire();
            $affectRows = QueryDelegate::$type($this);
            (isset($this->events[self::AFTER_DELETE]) && $affectRows > 0) && $this->events[self::AFTER_DELETE]->fire();
            $this->model->clearEntityCache($this->id);
        }
        if ($isClearCache) {
            $this->id = 0;
            $this->attributes = [];
        }
    }

    private function cascadDelete($callback)
    {
        $this->kdelete(false);
        $relations = $this->model->relations;
        if ($relations) {
            foreach ($relations as $val) {
                if ($val->isDel) {
                    $callback($val);
                }
            }
        }
    }

    /**
     * 删除自己及关联数据
     */
    public function rdelete()
    {
        $this->cascadDelete(function ($val) {
            QueryDelegate::kdeleteByField($val->initQuery($this));
        });
    }

    /**
     * 删除自己及关联实体集合
     */
    public function redelete()
    {
        $this->cascadDelete(function ($val) {
            $val->initQuery($this)->delfor();
        });
    }

    public function collections($relation)
    {
        if (!isset($this->model->relations[$relation])) {
            throw new \Exception(
                '模型' . $this->model->modelName .
                '并没有命名为' . $relation . '的关系'
            );
        }
        $obj = $this->model->relations[$relation];
        return $obj->initQuery($this);
    }




}