<?php

namespace Dzz\Container;


trait Reflection
{
    public $map;

    public function build($className, $map = null)
    {
        if ($className instanceof \Closure) {
            return $className($this);
        }

        $this->map = $map;

        if (interface_exists($className)) {
            if (empty($this->map)) {
                throw new \Exception('没有找到接口映射实现变量' . $className);
            }
            $className = $this->map[$className];
            if (!$className) {
                throw new \Exception('没有找到接口映射实现');
            }
        }


        $reflector = new \ReflectionClass($className);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Can't instantiate this.");
        }
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return new $className;
        }
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);
        return $reflector->newInstanceArgs($dependencies);
    }

    private function getDependencies($parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    $dependencies[] = $parameter->getName();
                }
            } else {
                $dependencies[] = $this->build($dependency->name, $this->map);
            }
        }
        return $dependencies;
    }
}