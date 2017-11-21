<?php

namespace Dzz\Mapper;

use Dzz\Core\Entity;
use Dzz\Mapper\Mysql\Relation;
use Dzz\Mapper\Mysql\Filter;
use Dzz\Mapper\Mysql\Query;

abstract class Model extends BaseModel implements ModelInterface
{

    const PRIMARY_KEY = 'id';

    protected static $entities;
    protected static $entityClass = 'Dzz\Core\Entity';
    public $tableName;

    private $relations = [];
    private $eventHandlers = [];

    public function __construct()
    {
        parent::__construct();
        $this->setRelations();
        $this->setLister();
    }

    public static function create()
    {
        $self = self::get(func_get_args());
        $entity = new static::$entityClass($self);
        $self->attachEvents($entity);
        return $entity;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'modelName':
                return get_class($this);
                break;
            case 'relations':
                return $this->relations;
                break;
        }
    }

    protected function attachEvents(Entity $entity)
    {
        if (!empty($this->eventHandlers[Entity::BEFORE_INSERT])) {
            $entity->{Entity::BEFORE_INSERT}->attach($this->eventHandlers[Entity::BEFORE_INSERT], $this);
        }
        if (!empty($this->eventHandlers[Entity::BEFORE_UPDATE])) {
            $entity->{Entity::BEFORE_UPDATE}->attach($this->eventHandlers[Entity::BEFORE_UPDATE], $this);
        }
        if (!empty($this->eventHandlers[Entity::BEFORE_DELETE])) {
            $entity->{Entity::BEFORE_DELETE}->attach($this->eventHandlers[Entity::BEFORE_DELETE], $this);
        }
        if (!empty($this->eventHandlers[Entity::AFTER_INSERT])) {
            $entity->{Entity::AFTER_INSERT}->attach($this->eventHandlers[Entity::AFTER_INSERT], $this);
        }
        if (!empty($this->eventHandlers[Entity::AFTER_UPDATE])) {
            $entity->{Entity::AFTER_UPDATE}->attach($this->eventHandlers[Entity::AFTER_UPDATE], $this);
        }
        if (!empty($this->eventHandlers[Entity::AFTER_DELETE])) {
            $entity->{Entity::AFTER_DELETE}->attach($this->eventHandlers[Entity::AFTER_DELETE], $this);
        }
    }

    public static function entity($id)
    {
        $id  = intval($id);
        $cls = self::getClass();
        !isset(self::$entities[$cls]) && self::$entities[$cls] = [];

        if (self::$entities[$cls][$id] === null) {
            $filter = static::filter()->where(self::PRIMARY_KEY, '=', $id);
            self::$entities[$cls][$id] = self::query($filter)->one();
        }
        return self::$entities[$cls][$id];
    }

    public static function filter()
    {
        $self = self::get(func_get_args());
        $filter = new Filter($self->fields);
        return $filter;
    }

    public static function query(Filter $filter = null)
    {
        $self = self::get(func_get_args());
        return new Query($self, $filter);
    }

    public function clearEntityCache($id)
    {
        $cls = self::getClass();
        if (isset(static::$entities[$cls][$id])) {
            unset(static::$entities[$cls][$id]);
        }
    }

    public function addListener($e, $func)
    {
        if (!in_array($e, Entity::$action)) {
            throw new \Exception('无效的事件名称: ' . $e);
        }
        $this->eventHandlers[$e] = $func;
    }

    public static function fetchAll($conditions, $fields, $options = array())
    {
        empty($conditions) && $conditions = [];
        empty($options) && $options = [];
        empty($fields) && $fields = 'id';
        $fields = explode(',', $fields);

        foreach ($fields as $key => $field) {
            $fields[$key] = trim($field);
            if ($fields[$key] == '') {
                unset($fields[$key]);
            }
        }
        $options = array_merge(['orderBy' => 'id DESC', 'limitNum' => 0, 'limitStart' => 0], $options);

        $filter = static::filter($conditions);
        $query  = self::query($filter);
        if ($fields) {
            $query = call_user_func_array([$query, 'fields'], $fields);
        }
        $query->orderBy($options['orderBy']);

        return $query->all($options['limitNum'], $options['limitStart']);
    }

    public static function fetchCount($conditions = array())
    {
        return self::query(static::filter($conditions))->count();
    }

    protected function hasOne($relationName, $modelName, $toField, $isDel = false, $myField = Model::PRIMARY_KEY)
    {
        return $this->relation(Relation::ONE_TO_ONE, $relationName, $modelName, $toField, $myField, $isDel);
    }

    protected function hasMany($relationName, $modelName, $toField, $isDel = false, $myField = Model::PRIMARY_KEY)
    {
        return $this->relation(Relation::ONE_TO_MANY, $relationName, $modelName, $toField, $myField, $isDel);
    }

    private function relation($relation, $relationName, $modelName, $toField, $myField = Model::PRIMARY_KEY, $isDel)
    {
        if (isset($this->relations[$relationName])) {
            throw new \Exception('已经存在一个命名为' . $relationName . '的关系');
        }
        $relation = new Relation($relation, $relationName, $modelName, $toField, $myField, $isDel);
        $this->relations[$relationName] = $relation;
        return $relation;
    }

}