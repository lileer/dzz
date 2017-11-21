<?php

namespace Common\Models;

use Dzz\Core\Entity;
use Dzz\Mapper\Model;

class Products extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'products';
    }

    public function setRelations()
    {
//        $this->hasOne('productsCate', __NAMESPACE__ . '\ProductsCate', Model::PRIMARY_KEY, false, 'cate_id');
        $this->hasMany('productSpecs', __NAMESPACE__ . '\ProductsSpecs', 'products_id', true);
    }

    public function setLister()
    {
//        $this->addListener(Entity::BEFORE_INSERT, 'beforeInsertProduct');
//        $this->addListener(Entity::AFTER_INSERT, 'afterInsertProduct');
        $this->addListener(Entity::AFTER_DELETE, 'onAfterDelete');

    }

    public function beforeInsertProduct()
    {
//        echo __METHOD__;
    }

    public function afterInsertProduct()
    {
//        echo __METHOD__;
    }


    public function onAfterDelete()
    {
        echo Products . "\n\n";
    }
}