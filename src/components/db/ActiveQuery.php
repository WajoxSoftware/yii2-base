<?php
namespace app\components\db;

use wajox\yii2base\helpers\TextHelper;

class ActiveQuery extends \yii\db\ActiveQuery
{
	public function byId(int $id): ActiveQuery
	{
		return $this->where(['id' => $id]);
	}
}