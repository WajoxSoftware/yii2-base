<?php
namespace wajox\yii2base\components\db;

use wajox\yii2base\components\base\Object;

class Repository extends Object
{
	public function __construct(array $map)
	{
		$this->loadMap($map);
	}

	public function get($name)
	{
		return $this->getDependency($name);
	}

	public function find($name): ActiveQuery
	{
		$className = $this->get($name);

		return $className::find();
	}

	public function insert($name, $rows)
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
		$name,
		$attributes,
		$condition = '',
		$params = []
	) {
		$className = $this->get($name);

		return $className::updateAll(
			$attributes,
			$condition,
			$params
		);
	}

	public function deleteAll($name, $condition = '', $params = [])
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