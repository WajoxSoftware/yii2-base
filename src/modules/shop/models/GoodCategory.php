<?php
namespace wajox\yii2base\modules\shop\models;

use wajox\yii2base\modules\shop\models\query\GoodCategoryQuery;

class GoodCategory extends \wajox\yii2base\components\db\ActiveRecord
{
    const VIEW_ROUTE = '/shop/goods/index';

    const STATUS_ID_ACTIVE = 100;
    const STATUS_ID_ARCHIVE = 101;

    public static function tableName()
    {
        return 'good_category';
    }

    public function rules()
    {
        return [
            [['parent_id', 'status_id'], 'integer'],
            [['url', 'title', 'status_id'], 'required'],
            [['parents_ids', 'url', 'title'], 'filter', 'filter' => 'strip_tags'],
            [['parents_ids', 'title'], 'filter', 'filter' => 'htmlentities'],
            [['parents_ids', 'url', 'title'], 'filter', 'filter' => 'trim'],
            [['parents_ids', 'url', 'title'], 'string', 'max' => 255],
            ['url', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'parent_id' => \Yii::t('app/attributes', 'Parent ID'),
            'parents_ids' => \Yii::t('app/attributes', 'Parents Ids'),
            'url' => \Yii::t('app/attributes', 'Url'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'status_id' => \Yii::t('app/attributes', 'Status ID'),
        ];
    }

    public static function find()
    {
        return self::createObject(
            GoodCategoryQuery::className(),
            [get_called_class()]
        );
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_ACTIVE =>  \Yii::t('app/attributes', 'Good Categoy Status ID Active'),
            self::STATUS_ID_ARCHIVE =>  \Yii::t('app/attributes', 'Good Categoy Status ID Archive'),
        ];
    }

    public function getStatus()
    {
        return $this::getStatusIdList()[$this->status_id];
    }

    public function getParent()
    {
        return $this->hasOne(GoodCategory::className(), ['id' => 'parent_id']);
    }

    public function getParents()
    {
        if ($this->parent_id == 0
            || $this->parents_ids == ''
        ) {
            return [];
        }

        $ids = explode(',', $this->parents_ids);

        return $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->byIds($ids)
            ->orderBy('id ASC')
            ->all();
    }
}
