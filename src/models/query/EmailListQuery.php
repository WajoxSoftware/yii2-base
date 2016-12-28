<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class EmailListQuery extends ActiveQuery
{
    public function byUrl($id)
    {
        return $this->where([
            'url' => htmlspecialchars($url),
        ]);
    }
}
