<?php
namespace wajox\yii2base\modules\shop\models;

class GoodLetter extends \wajox\yii2base\components\db\ActiveRecord
{
    const TYPE_ID_E_ORDER_NEW = 100;
    const TYPE_ID_E_ORDER_PAID = 101;

    const TYPE_ID_COD_ORDER_NEW = 200;
    const TYPE_ID_COD_ORDER_PAID = 201;
    const TYPE_ID_COD_ORDER_SEND = 202;
    const TYPE_ID_COD_ORDER_DELIVERED = 203;
    const TYPE_ID_COD_ORDER_RETURNED = 204;

    const TYPE_ID_ORDER_NEW = 301;
    const TYPE_ID_ORDER_PAID = 302;
    const TYPE_ID_ORDER_SEND = 303;
    const TYPE_ID_ORDER_DELIVERED = 304;
    const TYPE_ID_ORDER_RETURNED = 305;

    const LIST_TYPE_ELECTRONIC = 100;
    const LIST_TYPE_PHYSICAL = 200;
    const LIST_TYPE_COD = 300;

    public static function tableName()
    {
        return 'good_letter';
    }

    public function rules()
    {
        return [
            [['title', 'content_text'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'content_text', 'content_html'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'content_text', 'content_html'], 'filter', 'filter' => 'trim'],
            [['good_id', 'type_id'], 'required'],
            [['good_id', 'type_id'], 'integer'],
            [['delay'], 'number'],
            [['content_html'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['type_id', 'in', 'range' => array_keys($this::getTypeIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'delay' => \Yii::t('app/attributes', 'Good Letter Delay'),
            'title' => \Yii::t('app/attributes', 'Subject'),
            'content_html' => \Yii::t('app/attributes', 'Good Letter Email Content Html'),
            'content_text' => \Yii::t('app/attributes', 'Good Letter Email Content Text'),
            'type_id' => \Yii::t('app/attributes', 'Good Letter Type'),
        ];
    }

    public function getDelayTime()
    {
        return 'Через '.$this->delay.' ч.';
    }

    public function getLetterType()
    {
        return $this::getTypeIdList()[$this->type_id];
    }

    public static function getTypeIdList()
    {
        $arr = [];
        $arr += self::getElectronicTypeIdList();
        $arr += self::getCodTypeIdList();
        $arr += self::getPhysicalTypeIdList();

        return $arr;
    }

    public static function getPhysicalAllTypeIdList()
    {
        return array_merge(
                self::getCodTypeIdList(),
                self::getPhysicalTypeIdList()
            );
    }

    public static function getElectronicTypeIdList()
    {
        return [
            self::TYPE_ID_E_ORDER_NEW => \Yii::t('app/attributes', 'Good Letter Type ID E Order New'),
            self::TYPE_ID_E_ORDER_PAID => \Yii::t('app/attributes', 'Good Letter Type ID E Order Paid'),
        ];
    }

    public static function getCodTypeIdList()
    {
        return [
            self::TYPE_ID_COD_ORDER_NEW => \Yii::t('app/attributes', 'Good Letter Type ID Cod Order New'),
            self::TYPE_ID_COD_ORDER_PAID => \Yii::t('app/attributes', 'Good Letter Type ID Cod Order Paid'),
            self::TYPE_ID_COD_ORDER_SEND => \Yii::t('app/attributes', 'Good Letter Type ID Cod Order Send'),
            self::TYPE_ID_COD_ORDER_DELIVERED => \Yii::t('app/attributes', 'Good Letter Type ID Cod Order Delivered'),
            self::TYPE_ID_COD_ORDER_RETURNED => \Yii::t('app/attributes', 'Good Letter Type ID Cod Order Returned'),
        ];
    }

    public static function getPhysicalTypeIdList()
    {
        return [
            self::TYPE_ID_ORDER_NEW => \Yii::t('app/attributes', 'Good Letter Type ID Order New'),
            self::TYPE_ID_ORDER_PAID => \Yii::t('app/attributes', 'Good Letter Type ID Order Paid'),
            self::TYPE_ID_ORDER_SEND => \Yii::t('app/attributes', 'Good Letter Type ID Order Send'),
            self::TYPE_ID_ORDER_DELIVERED => \Yii::t('app/attributes', 'Good Letter Type ID Order Delivered'),
            self::TYPE_ID_ORDER_RETURNED => \Yii::t('app/attributes', 'Good Letter Type ID Order Returned'),
        ];
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
