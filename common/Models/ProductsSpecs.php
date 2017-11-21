<?php

namespace Common\Models;

use Dzz\Core\Entity;
use Dzz\Mapper\Model;

class ProductsSpecs extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'products_spec';
    }

    public function setRelations()
    {

    }

    public function setLister()
    {
        $this->addListener(Entity::AFTER_DELETE, 'onAfterDelete');

    }

    public function onAfterDelete()
    {

        echo ProductsSpecs . "\n\n";
    }

}