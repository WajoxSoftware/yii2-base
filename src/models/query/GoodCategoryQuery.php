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

    public function byParentId($parentId)
    {
    	return $this->where([
    		'parent_id' => intval($parentId),
    	]);
    }
}
