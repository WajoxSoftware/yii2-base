<?php
namespace wajox\yii2base\components\db;

use wajox\yii2base\components\base\Component;

class Repository extends Component
{
    public function __construct(array $params = [])
    {
        $params['map'] = isset($params['map']) ? $params['map'] : [];
        $this->loadMap($params['map']);
    }

    public function get(string $name)
    {
        return $this->getDependency($name);
    }

    public function find(string $name): ActiveQuery
    {
        $className = $this->get($name);

        return $className::find();
    }

    public function insert(string $name, array $rows)
    {
        $obj = $this->createObject($name);

        return $this
            ->getDb()
            ->createCommand()
            ->batchInsert(
                $obj->tableName(),
                $obj->attributes(),
                $rows
            )
            ->execute();
    }

    public function update(string $name, array $set, array $where)
    {
        $name = $this->createObject($name);

        return $this
               ->getDb()
               ->createCommand()->update(
                $name->tableName(),
                $set,
                $where
            )->execute();
    }

    public function updateAll(
        string $name,
        array $attributes,
        string $condition = '',
        array $params = []
    ) {
        $className = $this->get($name);

        return $className::updateAll(
            $attributes,
            $condition,
            $params
        );
    }

    public function deleteAll(string $name, string $condition = '', array $params = [])
    {
        $className = $this->get($name);

        return $className::deleteAll(
            $condition,
            $params
        );
    }

    protected function loadMap(array $map): Repository
    {
        foreach ($map as $name => $definition) {
            $this->setDependency($name, $definition);
        }

        return $this;
    }
}
