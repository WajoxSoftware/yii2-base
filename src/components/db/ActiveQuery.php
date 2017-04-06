<?php
namespace wajox\yii2base\components\db;

class ActiveQuery extends \yii\db\ActiveQuery
{
    public function byIds(array $ids): ActiveQuery
    {
        return $this->where(['id' => array_filter($ids, 'intval')]);
    }

    public function byId(int $id): ActiveQuery
    {
        return $this->where(['id' => intval($id)]);
    }

    public function viaClass(string $className, array $link, callable $callable = null): ActiveQuery
    {
        return $this->viaTable(
            $className::tableName(),
            $link,
            $callable
        );
    }
}
