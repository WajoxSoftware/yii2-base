<?php
namespace wajox\yii2base\components\db;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use \wajox\yii2base\traits\AppTrait;
    use \wajox\yii2base\traits\DiContainerTrait;
    use \wajox\yii2base\traits\I18nTrait;

    public static function find()
    {
        return $this->createObject(
            ActiveQuery::className(),
            [get_called_class()]
        );
    }

    public function hasOne($class, $link)
    {
        return parent::hasOne(
            $this->getDepencency($class),
            $link
        );
    }

    public function hasMany($class, $link)
    {
        return parent::hasMany(
            $this->getDepencency($class),
            $link
        );
    }
}
