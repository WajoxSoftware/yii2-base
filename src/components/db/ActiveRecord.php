<?php
namespace wajox\yii2base\components\db;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use wajox\yii2base\traits\AppTrait;
    use wajox\yii2base\traits\DiContainerTrait;
    use wajox\yii2base\traits\I18nTrait;
}
