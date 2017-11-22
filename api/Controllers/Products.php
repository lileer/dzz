<?php

namespace Api\Controllers;

use Api\Core\ApiController;

class Products extends ApiController
{

    public static function index()
    {

//
//        $filter = new Filter();
//        $filter->where('id', '=', $id);
//        $query = \Common\Models\Products::query($filter);
//
//        var_dump($query->kone());exit;
//        $query->join('products_spec', 'products.id=products_spec.products_id')
//            ->join('products_spec', 'products.id=products_spec.products_id')
//            ->groupBy('asfd')11
//            ->orderBY(ASD)
//            ->all();



//        RedisManager::get()->kset('aa', 'bbs');
//
//        var_dump(        RedisManager::get()->kget('aa'));
//

//
//        $entity = \Common\Models\Products::entity($id);
//        $result = $entity->collections('productSpecs')->one();
//        var_dump($result->name);
//       $entity = \Common\Models\Products::entity($id);
//
//       $cate = $entity->productsCate;
//       var_dump($cate);

////
//            $entitty = \Common\Models\Products::create();
//            $entitty->setAttributes(['name' => '333333', 'cate_id' => 1])->ksave();
//
//        $entitty = \Common\Models\ProductsSpecs::create();
//        $entitty->setAttributes(['products_id' => 1, 'name' => 'aoe'])->ksave();


//        $entity = \Common\Models\Products::entity($id);
//        $entity->setAttributes(['name' => '111'])->ksave();
//        $entity->collections('productSpecs')->where('name', '=', 444)->delete();
//        $entity = \Common\Models\Products::entity($id)->kdelete();

//        \Common\Models\Products::entity($id)->rdelete();

//
//////////////////////////////
//        $entitty = \Common\Models\Products::create();
//        $entitty->setAttributes(['name' => '34343eeeeeee', 'cate_id' => 1])->ksave();
//
//        $entitty = \Common\Models\ProductsSpecs::create();
//        $entitty->setAttributes(['products_id' => '2', 'name' => 'hah33dd'])->ksave();

//                \Common\Models\Products::entity($id)->rdelete();
//                \Common\Models\Products::entity($id)->redelete();

//
//        $filter = new Filter();
//        $filter->where('products_id', '=', 1);
//        $query = \Common\Models\ProductsSpecs::query($filter);
//        var_dump($query->kall());


//                        \Common\Models\Products::entity(1)->redelete();

//            try {
////                Transaction::begin();
////
////                $entitty = \Common\Models\Products::create();
////                $entitty->setAttributes(['name' => '我的大脑', 'cate_id' => 1])->ksave();
////                $entitty = \Common\Models\ProductsSpecs::create();
////                $entitty->setAttributes(['products_id' => '2', 'name' => null])->ksave();
////                Transaction::commit();
//                throw new \PDOException();
//            } catch (\PDOException $e) {
//                echo eee;
//            }catch (\RuntimeException $e) {
//                ECHO IIII;
//            }

//        $callback = function () {
//            self::$a = 'b';
//        };
//        $callback = $callback->bindTo(ErrorHandler::get());

//        $ex = Dzz::$app->ex;
//        $ex();

//        throw new \Error('dddff', 500);
//        trigger_error('人为触发一个错误', E_USER_ERROR); //人为触发错误

    }

}