<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/28
 * Time: 下午2:46
 */

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