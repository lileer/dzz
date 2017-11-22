<?php

namespace Dzz\Mapper\Mysql;

use Dzz\Mapper\Model;

class Relation extends Query
{

    /**
     * 一对一关系
     */
    const ONE_TO_ONE = 1;

    /**
     * 一对多关系
     */
    const ONE_TO_MANY = 2;

    /**
     * 关系类型
     *
     * @var int
     */
    public $relationship = 0;

    /**
     * 关系名称
     *
     * @var string
     */
    public $relationName = '';

    /**
     * 关联的模型
     *
     * @var string
     */
    public $modelName = '';

    /**
     * 当前模型的字段，默认为主键
     *
     * @var string
     */
    public $myField = '';

    /**
     * 关联模型的字段
     *
     * @var string
     */
    public $toField = '';

    /**
     * 删除操作时关联实体是否需要删除
     *
     * @var bool
     */
    public $isDel = '';



    public function __construct($relationship, $name, $modelName, $toField, $myField = Model::PRIMARY_KEY, $isDel = false)
    {
        $this->relationship = $relationship;
        $this->relationName = $name;
        $this->modelName = $modelName;
        $this->toField = $toField;
        $this->myField = $myField;
        $this->isDel = $isDel;
    }

    public function initQuery($entity)
    {
        try {
            $model = call_user_func($this->modelName . '::get');
        } catch (\Exception $e) {
            throw new \Exception("Load model {$this->modelName} is failed");
        }
        $filter = new Filter();
        $myField = $this->myField;
        $filter->where($this->toField, '=', $entity->$myField);

        parent::__construct($model, $filter);

        return $this;
    }

    public function delfor($num = 0)
    {
        $arr = $this->all($num);
        foreach ($arr as $key => $obj) {
            $obj->kdelete($num);
        }
    }

    public function update()
    {
        $arr = $this->all();

        foreach ($arr as $key => $obj) {
            $obj->setAttributes($this->queryData)->save();
        }
    }

}