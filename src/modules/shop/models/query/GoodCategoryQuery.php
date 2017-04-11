<?php
namespace wajox\yii2base\modules\shop\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class GoodCategoryQuery extends ActiveQuery
{
    public function byUrl(string $url)
    {
        return $this->where([
            'url' => htmlspecialchars($url),
        ]);
    }

    public function byParentId($parentId)
    {
        return $this->where([
            'parent_id' => $parentId,
        ]);
    }
}
