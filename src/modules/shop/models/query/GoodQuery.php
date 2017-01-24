<?php
namespace wajox\yii2base\modules\shop\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class GoodQuery extends ActiveQuery
{
    public function byUrl(string $url)
    {
        return $this->where([
            'url' => htmlspecialchars($url),
        ]);
    }

    public function byCategoryId(int $categoryId)
    {
        return $this->where([
            'category_id' => intval($categoryId),
        ]);
    }
}
