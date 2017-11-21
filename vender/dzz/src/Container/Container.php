<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/13
 * Time: 上午10:25
 */

namespace Dzz\Container;


use Dzz\Core\Instances;
use \Dzz\ServicesProvider\ServicesProviderInterface;

class Container implements \ArrayAccess
{

    use Reflection;

    protected $registry = [];
    protected $registryInterfaceMap = [];

    public function register(ServicesProviderInterface $provider, $values = [])
    {
        $provider->register($this);
        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
        return $this;
    }

    public function set($key, $value = null, $dependInterfaceMap = null)
    {
        $this->registry[$key] = $value;
        if (is_array($dependInterfaceMap) && !empty($dependInterfaceMap)) {
            $this->registryInterfaceMap[$key] = $dependInterfaceMap;
        }
        return $this;
    }

    public function get($key)
    {
        if ($obj = Instances::get($key)) {
            return $obj;
        }

        if ($this->has($key)) {
            $value =  $this->registry[$key];

            if ($value instanceof \Closure) {
                return $value($this);
            }
            if (is_object($value)) {
                if (is_callable($value)) {
                    return $value();
                }
                return $value;
            }

            if (is_array($value)) {

            }

            if (is_string($value) && class_exists($value)) {
                $obj = $this->build($value, $this->registryInterfaceMap[$key]);
                Instances::set($value, $obj);
                return $obj;
            } else if (is_string($value)) {
                return $value;
            }
        } else {
            if (class_exists($key)) {
                $obj = $this->build($key, $this->registryInterfaceMap[$key]);
                Instances::set($key, $obj);
                return $obj;
            }
        }
//        throw new \Exception('Not found ');
        return false;
    }

    public function has($key)
    {
        return isset($this->registry[$key]) ? true : false;
    }

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        unset($this->registry[$key]);
    }



}