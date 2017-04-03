<?php
namespace wajox\yii2base\models;

class LogParam extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const PARAM_ID_TRAFFIC_STREAM_ID = 100;
    const PARAM_ID_OFFER_TYPE_ID = 200;
    const PARAM_ID_OFFER_ITEM_ID = 300;

    public static function tableName()
    {
        return 'log_param';
    }

    public function rules()
    {
        return [
            [['string_value'], 'filter', 'filter' => 'strip_tags'],
            [['string_value'], 'filter', 'filter' => 'trim'],
            [['id', 'param_id', 'log_id', 'int_value'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'log_id' => \Yii::t('app/attributes', 'Log ID'),
            'param_url' => \Yii::t('app/attributes', 'Log Param ID'),
            'int_value' => \Yii::t('app/attributes', 'Integer Value'),
            'string_value' => \Yii::t('app/attributes', 'String Value'),
        ];
    }

    public function getLog()
    {
        return $this->hasOne(Log::className(), ['id' => 'log_id']);
    }
}
