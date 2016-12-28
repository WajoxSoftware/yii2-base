<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class GoodQuery extends ActiveQuery
{
    public function byUrl($id)
    {
        return $this->where([
            'url' => htmlspecialchars($url),
        ]);
    }

    public function byCategoryId($categoryId)
    {
        return $this->where([
            'category_id' => intval($categoryId),
        ]);
    }
}
