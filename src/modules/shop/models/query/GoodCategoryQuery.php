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

    public function byParentId(int $parentId)
    {
        return $this->where([
            'parent_id' => intval($parentId),
        ]);
    }
}
