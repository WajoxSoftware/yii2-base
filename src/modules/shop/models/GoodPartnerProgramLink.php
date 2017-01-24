<?php
namespace wajox\yii2base\models;

class GoodPartnerProgramLink extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'good_partner_program_link';
    }

    public function rules()
    {
        return [
            [['url', 'description'], 'filter', 'filter' => 'strip_tags'],
            [['url', 'description'], 'filter', 'filter' => 'trim'],
            [['good_partner_program_id', 'url'], 'required'],
            [['good_partner_program_id'], 'integer'],
            [['url', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_partner_program_id' => \Yii::t('app/attributes', 'Good Partner Program ID'),
            'url' => \Yii::t('app/attributes', 'Url'),
            'description' => \Yii::t('app/attributes', 'Description'),
        ];
    }
}
