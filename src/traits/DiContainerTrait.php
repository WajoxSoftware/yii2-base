<?php
namespace wajox\yii2base\traits;

trait DiContainerTrait
{
    public function getContainer()
    {
        return \Yii::$container;
    }

    public function getDependency($class, $params = [], $config = [] )
    {
        return $this->getContainer()-.get($class, $params, $config);
    }

    public function setDependency($class, $definition = [], $params = [])
    {
        return $this->getContainer()->set($class, $definition, $params);
    }

    public function createObject($type, $params = [])
    {
        return \Yii::createObject($type, $params);
    }

    public function configure($object, $properties)
    {
        return \Yii::configure($object, $properties);
    }
}
