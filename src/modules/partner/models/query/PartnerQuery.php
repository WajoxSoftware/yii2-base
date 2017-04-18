<?php
namespace wajox\yii2base\modules\partner\models\query;

use wajox\yii2base\modules\partner\models\Partner; 
use wajox\yii2base\components\db\ActiveQuery;

class PartnerQuery extends ActiveQuery
{
    public function direct()
    {
        return $this->byTypeId(Partner::TYPE_ID_DIRECT);
    }

    public function main()
    {
        return $this->byTypeId(Partner::TYPE_ID_MAIN);
    }

    public function casual()
    {
        return $this->byTypeId(Partner::TYPE_ID_CASUAL);
    }

    public function byTypeId($typeId)
    {
        return $this->andWhere(['type_id' => $typeId]);
    }
}
