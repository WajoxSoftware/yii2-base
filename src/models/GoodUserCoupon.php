<?php
namespace wajox\yii2base\models;

class GoodUserCoupon extends \wajox\yii2base\components\db\ActiveRecord
{
    const DATETIME_FORMAT = 'd.m.Y H:i';

    const TYPE_ID_BETWEEN = 100;
    const TYPE_ID_FINISH = 101;

    const FINISHED_MESSAGE_FIELD = 'finished_message';
    const REDIRECT_GOOD_ID_FIELD = 'redirect_good_id';
    const REDIRECT_URL_FIELD = 'redirect_url';
    const FINISH_TYPE_ID_FIELD = 'finish_type_id';

    const FINISH_TYPE_ID_REDIRECT = 100;
    const FINISH_TYPE_ID_GOOD = 101;
    const FINISH_TYPE_ID_MESSAGE = 103;

    public static function tableName()
    {
        return 'good_user_coupon';
    }

    public function behaviors()
    {
        return [
            'serializedAttributes' => [
                'class' => "\baibaratsky\yii\behaviors\model\SerializedAttributes",
                'attributes' => ['extra'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['partner_id', 'good_id', 'type_id', 'created_at', 'start_at', 'finish_at'], 'integer'],
            [['good_id', 'sum', 'created_at', 'type_id', 'start_at', 'finish_at'], 'required'],
            [['sum'], 'number'],
            ['partner_id', 'unique', 'targetAttribute' => ['good_id', 'partner_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'partner_id' => \Yii::t('app/attributes', 'Partner ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'sum' => \Yii::t('app/attributes', 'Good User Coupon Sum'),
            'start_at' => \Yii::t('app/attributes', 'Start From Date'),
            'finish_at' => \Yii::t('app/attributes', 'Start FromTo Date'),
            'type_id' => \Yii::t('app/attributes', 'Type ID'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'extra' => \Yii::t('app/attributes', 'Extra'),
        ];
    }

    public static function getTypeIdList()
    {
        return [
            self::TYPE_ID_FINISH => \Yii::t('app/attributes', 'Good User Coupon Type ID Finish'),
            self::TYPE_ID_BETWEEN => \Yii::t('app/attributes', 'Good User Coupon Type ID Between'),
        ];
    }

    public static function getFinishTypeIdList()
    {
        return [
            self::FINISH_TYPE_ID_REDIRECT => \Yii::t('app/attributes', 'Good User Coupon Finish Type ID Redirect'),
            self::FINISH_TYPE_ID_GOOD => \Yii::t('app/attributes', 'Good User Coupon Finish Type ID Good'),
            self::FINISH_TYPE_ID_MESSAGE => \Yii::t('app/attributes', 'Good User Coupon Finish Type ID Message'),
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

    public function getPartnerFullName()
    {
        if ($this->partner) {
            return $this->partner->fullName;
        }

        return \Yii::t('app/general', 'All');
    }

    public function getFinishDate()
    {
        if ($this->finish_at == 0) {
            return \Yii::t('app/general', 'Unlimited');
        }

        return date(self::DATETIME_FORMAT, $this->finish_at);
    }

    public function getStartDate()
    {
        if ($this->start_at == 0) {
            return \Yii::t('app/general', 'Unlimited');
        }

        return date(self::DATETIME_FORMAT, $this->start_at);
    }

    public function getFinishType()
    {
        return $this::getFinishTypeIdList()[$this->finishTypeId];
    }

    public function getIsAction()
    {
        return $this->type_id == self::TYPE_ID_FINISH;
    }

    public function getIsCoupon()
    {
        return $this->type_id == self::TYPE_ID_BETWEEN;
    }

    public function getIsActive()
    {
        if ($this->start_at == 0
            && $this->finish_at == 0
        ) {
            return true;
        }

        $currentTime = time();

        if ($this->finish_at - $this->start_at > 0
            && $this->finish_at  > $currentTime
            && $this->start_at < $currentTime
        ) {
            return true;
        }

        return false;
    }

    public function getIsFinishRedirect()
    {
        return $this->finishTypeId == self::FINISH_TYPE_ID_REDIRECT;
    }

    public function getIsFinishGood()
    {
        return $this->finishTypeId == self::FINISH_TYPE_ID_GOOD;
    }

    public function getIsFinishMessage()
    {
        return $this->finishTypeId == self::FINISH_TYPE_ID_MESSAGE;
    }

    public function getSumRUR()
    {
        return $this->sum;
    }

    public function getDueDate()
    {
        return $this->getFinishDate();
    }

    public function getFinishTypeId()
    {
        return $this->getExtraParam(self::FINISH_TYPE_ID_FIELD);
    }

    public function getRedirectUrl()
    {
        return $this->getExtraParam(self::REDIRECT_URL_FIELD);
    }

    public function getRedirectGoodId()
    {
        return $this->getExtraParam(self::REDIRECT_GOOD_ID_FIELD);
    }

    public function getRedirectGood()
    {
        return Good::findOne($this->redirectGoodId);
    }

    public function getFinishedMessage()
    {
        return $this->getExtraParam(self::FINISHED_MESSAGE_FIELD);
    }

    protected function getExtraParam($field, $default = null)
    {
        if (isset($this->extra[$field])) {
            return $this->extra[$field];
        }

        return $default;
    }
}
