<?php

namespace Dzz\Mapper;

use Dzz\Mapper\Redis\Manager;

class QueryDelegate
{

    public static function __callStatic($name, $arguments)
    {
        switch ($name) {
            case 'kone':
                return self::kresult($arguments[0], $name);
                break;
            case 'kall':
                return self::kresult($arguments[0], $name);
                break;
        }
    }

    public static function save($entity)
    {
        $modelName = $entity->model->modelName;
        $query = $modelName::query();
        if ($entity->id) {
            $filter = $modelName::filter()->where(Model::PRIMARY_KEY, '=', $entity->id);
            return $modelName::query($filter)->setData($entity->getAttributes())->update();
        } else {
            $entity->id = $query->setData($entity->getAttributes())->insert();
        }
    }

    public static function ksave($entity)
    {
        $affectRows = self::save($entity);
        $modelName = $entity->model;
        $query = $modelName::query();
        if ($entity->id || $affectRows == 1) {
            $key = $modelName->tableName . ":id='" . $entity->id . "'";
            $row = $query->where('id', '=', $entity->id)->one()->getAttributes();
            Manager::get()->kset($key, json_encode($row, true));
            return true;
        }
        return false;
    }

    public static function delete($entity)
    {
        $modelName = $entity->model->modelName;
        $filter = $modelName::filter()->where(Model::PRIMARY_KEY, '=', $entity->id);
        return $modelName::query($filter)->delete(1);
    }

    public static function kdelete($entity)
    {
        if (self::delete($entity)) {
            $key = $entity->model->tableName . ":id='" . $entity->id . "'";
            if (Manager::get()->kisExist($key)) {
                return Manager::get()->kdelete($key);
            }
        }
        return false;
    }

    public static function kdeleteByField($query)
    {
        if ($query->delete()) {
            $key = str_replace(' ', '', $query->model->tableName . ':' . trim($query->getParse()));
            var_dump($key);
            if (Manager::get()->kisExist($key)) {
                return Manager::get()->kdelete($key);
            }
        }
        return false;
    }

    public static function kresult($query, $type)
    {
       $key = $query->model->tableName . ':' . trim($query->getParse());
       $result = Manager::get()->kget($key);
       if (!empty($result)) {
            return json_decode($result, true);
       }

       if ($type == 'kone') {
           $result = $query->one(true);
       } elseif ($type == 'kall') {
           $result = $query->all(0, 0, true);
       }
        Manager::get()->kset($key, json_encode($result, true));

        return $result;
    }



}