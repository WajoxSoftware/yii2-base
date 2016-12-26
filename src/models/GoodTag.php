<?php
namespace wajox\yii2base\models;

class GoodTag extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'good_tag';
    }

    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'strip_tags'],
            [['name'], 'filter', 'filter' => 'htmlentities'],
            [['name'], 'filter', 'filter' => 'trim'],
            [['repeat_count'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'repeat_count' => \Yii::t('app/attributes', 'Repeat Count'),
            'name' => \Yii::t('app/attributes', 'Name'),
        ];
    }
}
