<?php

namespace Common\Models;


class ProductsCate  extends \Dzz\Mapper\Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'products_cate';
    }

    public function setRelations()
    {
    }

    public function setLister()
    {
    }
}