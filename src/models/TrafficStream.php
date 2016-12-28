<?php
namespace wajox\yii2base\models;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use wajox\yii2base\services\web\UrlConverter;

class TrafficStream extends \wajox\yii2base\components\db\ActiveRecord
{
    const STATUS_ID_ACTIVE = 100;
    const STATUS_ID_INACTIVE = 101;

    public static function tableName()
    {
        return 'traffic_stream';
    }

    public function rules()
    {
        return [
            [['title', 'target_url'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'target_url'], 'filter', 'filter' => 'trim'],
            [['user_id', 'title', 'status_id', 'target_url'], 'required'],
            [['user_id'], 'integer'],
            [['title', 'target_url'], 'filter', 'filter' => 'strip_tags'],
            [['title'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'target_url'], 'filter', 'filter' => 'trim'],
            [['title'], 'string', 'max' => 255],
            ['status_id', 'in', 'range' => array_keys(self::getStatusIdList())],
            [['target_url'], 'string', 'max' => 255],
            //[['target_url'], 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'Referal User ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'target_url' => \Yii::t('app/attributes', 'Traffic Stream Target Url'),
        ];
    }

    public function getSource()
    {
        return $this->hasOne(TrafficSource::className(), ['id' => 'traffic_source_id']);
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id'])
        ->viaClass(TrafficStreamGood::className(), ['traffic_stream_id' => 'id']);
    }

    public function getTrafficCompany()
    {
        return $this->hasOne(TrafficCompany::className(), ['traffic_stream_id' => 'id']);
    }

    public function getTrafficGood()
    {
        return $this->hasOne(TrafficStreamGood::className(), ['traffic_stream_id' => 'id']);
    }

    public function getImages()
    {
        return $this->hasMany(TrafficStreamImage::className(), ['traffic_stream_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getManager()
    {
        return $this->hasOne(TrafficManager::className(), ['user_id' => 'id'])
        ->viaClass(User::tableName(), ['id' => 'user_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['user_id' => 'id'])
        ->viaClass(User::className(), ['id' => 'user_id']);
    }

    public function getPrices()
    {
        return $this->hasMany(TrafficStreamPrice::className(), ['traffic_stream_id' => 'id']);
    }

    public function getIsActive()
    {
        return $this->status_id == self::STATUS_ID_ACTIVE;
    }

    public function getTragetUrl()
    {
        return $this->createObject(UrlConverter::className())->extract($this->target_url);
    }

    public function getUrl($tag = 'sub1/sub2/sub3/sub4')
    {
        return str_replace('%2F', '/', Url::toRoute([
            '/traffic-streams/view',
            'id' => $this->id,
            'tag' => $tag,
        ], true));
    }

    public function goodsList()
    {
        $partner_id = $this->partner->id;

        $query = $this
            ->getRepository()
            ->find(Good::className())
            ->where([
                'status_id' => Good::STATUS_ID_ACTIVE,
                'partner_status_id' => Good::PARTNER_STATUS_ID_ACTIVE,
            ])->joinWith([
                'partnerPrograms' => function ($query) use ($partner_id) {
                    return $query->andWhere(['partner_id' => [0, $partner_id]]);
                },
            ]);

        return ArrayHelper::map($query->all(), 'id', 'title');
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_INACTIVE => \Yii::t('app/attributes', 'Traffic Stream Status Inactive'),
            self::STATUS_ID_ACTIVE => \Yii::t('app/attributes', 'Traffic Stream Status Active'),
        ];
    }

    public function getStatus()
    {
        return $this::getStatusIdList()[$this->status_id];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if (!$this->source->isActive) {
            $this->status_id = self::STATUS_ID_INACTIVE;
        }

        return parent::save($runValidation, $attributeNames);
    }
}
