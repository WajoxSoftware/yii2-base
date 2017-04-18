<?php
namespace wajox\yii2base\modules\partner\services;

use wajox\yii2base\modules\partner\models\Partner;
use wajox\yii2base\components\base\Object;

class PartnersManager extends Object
{
    public function find()
    {
        return $this
            ->getRepository()
            ->find(Partner::className());
    }
}