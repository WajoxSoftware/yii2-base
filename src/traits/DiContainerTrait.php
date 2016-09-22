<?php
namespace wajox\yii2base\traits;

trait DiContainerTrait
{
    public static function getContainer()
    {
        return \Yii::$container;
    }

    public static function getDependency($class, $params = [], $config = [])
    {
        return self::getContainer()->get($class, $params, $config);
    }

    public static function setDependency($class, $definition = [], $params = [])
    {
        return self::getContainer()->set($class, $definition, $params);
    }

    public static function createObject($type, $params = [])
    {
        return \Yii::createObject($type, $params);
    }

    public static function configure($object, $properties)
    {
        return \Yii::configure($object, $properties);
    }
}
