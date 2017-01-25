<?php
namespace wajox\yii2base\modules\payment\services;

use wajox\yii2base\components\base\Object;

class CustomersManager extends Object
{
    public function createBuilder($user): CustomerBuilder
    {
        return $this->createObject(
            CustomerBuilder::className(),
            [$user]
        );
    }
}
