<?php
namespace app\components\db;

use wajox\yii2base\helpers\TextHelper;

class ActiveQuery extends \yii\db\ActiveQuery
{
    public function byId(int $id): ActiveQuery
    {
        return $this->where(['id' => intval($id)]);
    }

    public function viaClass($className, $link, callable $callable = null)
    {
        return $this->viaTable(
            $className::tableName(),
            $link,
            $callable
        );
    }
}
