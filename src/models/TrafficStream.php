<?php
namespace wajox\yii2base\models;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;

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
            [['title', 'tag', 'full_tag'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'tag', 'full_tag'], 'filter', 'filter' => 'trim'],
            [['user_id', 'title', 'status_id', 'tag', 'full_tag', 'level', 'traffic_source_id', 'parent_id'], 'required'],
            [['user_id', 'level', 'parent_id', 'status_id'], 'integer'],
            [['title', 'tag', 'full_tag', 'parent_ids'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 50000],
            ['status_id', 'in', 'range' => array_keys(self::getStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'Referal User ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'tag' => \Yii::t('app/attributes', 'Traffic Stream Tag'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'content' => \Yii::t('app/attributes', 'Traffic Stream Content'),
        ];
    }

    public function getSource()
    {
        return $this->hasOne(TrafficSource::className(), ['id' => 'traffic_source_id']);
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

    public function getUrl()
    {
        return str_replace('%2F', '/', Url::toRoute([
            '/traffic-streams/view',
            'sourceTag' => $this->source->tag,
            'streamTag' => $this->full_tag,
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

    public function getParentIds()
    {
        return explode(',', $this->parent_ids);
    }

    public function getTags()
    {
        return explode('/', $this->full_tag);
    }
}
