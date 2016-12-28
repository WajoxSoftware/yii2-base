<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class UserActionLogQuery extends ActiveQuery
{
    public function byUserIdOrGuid($userId, $guid)
    {
        return $this
            ->where(['user_id' => intval($userId)])
            ->orWhere(['guid' => htmlspecialchars($guid)]);
    }
}
