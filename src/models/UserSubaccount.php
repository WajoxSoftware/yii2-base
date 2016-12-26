<?php
namespace wajox\yii2base\models;

class UserSubaccount extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_subaccount';
    }

    public function rules()
    {
        return [
            [['name', 'tag1', 'tag2', 'tag3', 'tag4'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'tag1', 'tag2', 'tag3', 'tag4'], 'filter', 'filter' => 'htmlentities'],
            [['name', 'tag1', 'tag2', 'tag3', 'tag4'], 'filter', 'filter' => 'trim'],
            [['user_id', 'name', 'tag1'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'tag1'], 'required'],
            [['name', 'tag1', 'tag2', 'tag3', 'tag4'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'name' => \Yii::t('app/attributes', 'Name'),
            'tag' => \Yii::t('app/attributes', 'User Subaccount Tag'),
            'tag1' => \Yii::t('app/attributes', 'User Subaccount Tag1'),
            'tag2' => \Yii::t('app/attributes', 'User Subaccount Tag2'),
            'tag3' => \Yii::t('app/attributes', 'User Subaccount Tag3'),
            'tag4' => \Yii::t('app/attributes', 'User Subaccount Tag4'),
        ];
    }

    public function getTag()
    {
        $tag = '/' . $this->tag1;

        if (empty($this->tag2)) {
            return $tag;
        }

        $tag .= '/' . $this->tag2;

        if (empty($this->tag3)) {
            return $tag;
        }

        $tag .= '/' . $this->tag3;

        if (empty($this->tag4)) {
            return $tag;
        }

        $tag .= '/' . $this->tag4;

        return $tag;
    }
}
