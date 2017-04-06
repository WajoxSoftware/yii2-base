<?php
namespace wajox\yii2base\modules\shop\models;

class GoodPartnerProgram extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'good_partner_program';
    }

    public function rules()
    {
        return [
            [['good_id'], 'required'],
            [['good_id', 'partner_id'], 'integer'],
            [['fee_1_level', 'fee_2_level'], 'number'],
            [['partner_link'], 'string'],
            ['partner_id', 'unique', 'targetAttribute' => ['good_id', 'partner_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'partner_id' => \Yii::t('app/attributes', 'Partner ID'),
            'fee_1_level' => \Yii::t('app/attributes', 'Fee 1 Level'),
            'fee_2_level' => \Yii::t('app/attributes', 'Fee 2 Level'),
            'partner_link' => \Yii::t('app/attributes', 'Partner Program Link'),
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

    public function getLinks()
    {
        return $this->hasMany(GoodPartnerProgramLink::className(), ['good_partner_program_id' => 'id']);
    }

    public function getPartnerFullName()
    {
        if ($this->partner) {
            return $this->partner->fullName();
        }

        return \Yii::t('app/attributes', 'Good All Partners');
    }

    public function getGoodTitle()
    {
        if ($this->good) {
            return $this->good->title;
        }

        return 'None';
    }
}
