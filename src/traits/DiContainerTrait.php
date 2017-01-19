<?php
namespace wajox\yii2base\traits;

trait DiContainerTrait
{
    public static function getContainer()
    {
        return \Yii::$container;
    }

    public static function getDependency(string $class, array $params = [], $config = [])
    {
        return self::getContainer()->get($class, $params, $config);
    }

    public static function setDependency(string $class, array $definition = [], array $params = [])
    {
        return self::getContainer()->set($class, $definition, $params);
    }

    public static function createObject(string $type, array $params = [])
    {
        return \Yii::createObject($type, $params);
    }

    public static function configure($object, $properties)
    {
        return \Yii::configure($object, $properties);
    }
}
