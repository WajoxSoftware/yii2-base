<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodUserCoupon;

class GoodUserCouponForm extends GoodUserCoupon
{
    const DATETIME_FORMAT = 'Y-m-d H:i';

    public $goodId;
    public $partnerId;
    public $sum;
    public $startDateTime;
    public $finishDateTime;
    public $typeId;

    public $finishTypeId;
    public $redirectUrl;
    public $redirectGoodId;
    public $finishedMessage;

    protected $model = null;

    public function rules()
    {
        return [
            [['partnerId', 'goodId', 'typeId', 'redirectGoodId', 'finishTypeId'], 'integer'],
            [['goodId', 'partnerId', 'sum', 'typeId', 'startDateTime', 'finishDateTime'], 'required'],
            [['sum'], 'number'],
            ['partner_id', 'unique', 'targetAttribute' => ['good_id', 'partner_id']],
            ['redirectUrl', 'url'],
            ['finishedMessage', 'string', 'max' => 150000],
            //[['startDateTime', 'finishDateTime'], 'date', 'format' => self::DATETIME_FORMAT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'partnerId' => \Yii::t('app/attributes', 'Partner ID'),
            'goodId' => \Yii::t('app/attributes', 'Good ID'),
            'sum' => \Yii::t('app/attributes', 'Good User Coupon Sum'),
            'startDateTime' => \Yii::t('app/attributes', 'Start From Date'),
            'finishDateTime' => \Yii::t('app/attributes', 'Start FromTo Date'),
            'typeId' => \Yii::t('app/attributes', 'Type ID'),
            'finishTypeId' => \Yii::t('app/attributes', 'Good User Coupon Finish Type ID'),
            'redirectUrl' => \Yii::t('app/attributes', 'Good User Coupon Redirect Url'),
            'redirectGoodId' => \Yii::t('app/attributes', 'Good User Coupon Redirect Good ID'),
            'finishedMessage' => \Yii::t('app/attributes', 'Good User Coupon Finished Message'),
        ];
    }

    public function setModel($model)
    {
        $this->model = $model;

        $this->loadModel();

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function saveModel()
    {
        $attributes = $this->getModelAttributes();
        $this->model->setAttributes($attributes);
        $this->model->extra = $attributes['extra'];

        return $this->model->save();
    }

    public function loadModel()
    {
        $this->typeId = $this->getModel()->type_id;
        $this->goodId = $this->getModel()->good_id;

        if (!$this->getModel()->isNewRecord) {
            $this->partnerId = $this->getModel()->partner_id;
            $this->sum = $this->getModel()->sum;
            $this->startDateTime = date(self::DATETIME_FORMAT, $this->getModel()->start_at);
            $this->finishDateTime = date(self::DATETIME_FORMAT, $this->getModel()->finish_at);
        }

        if ($this->getModel()->isAction) {
            $this->finishTypeId = $this->getModel()->finishTypeId;
            $this->redirectUrl = $this->getModel()->redirectUrl;
            $this->redirectGoodId = $this->getModel()->redirectGoodId;
            $this->finishedMessage = $this->getModel()->finishedMessage;
        }
    }

    public function getModelAttributes()
    {
        $attributes = [
                'type_id' => $this->typeId,
                'good_id' => $this->goodId,
                'partner_id' => $this->partnerId,
                'sum' => $this->sum,
                'start_at' => $this->getStartAt(),
                'finish_at' => $this->getFinishAt(),
            ];

        $attributes['extra'] = [
            GoodUserCoupon::FINISH_TYPE_ID_FIELD => $this->finishTypeId,
            GoodUserCoupon::REDIRECT_URL_FIELD => $this->redirectUrl,
            GoodUserCoupon::REDIRECT_GOOD_ID_FIELD => $this->redirectGoodId,
            GoodUserCoupon::FINISHED_MESSAGE_FIELD => $this->finishedMessage,
        ];

        return $attributes;
    }

    public function getStartAt()
    {
        if ($this->getModel()->isAction
            || empty($this->startDateTime)
        ) {
            return 0;
        }

        return strtotime($this->startDateTime);
    }

    public function getFinishAt()
    {
        if (empty($this->finishDateTime)) {
            return 0;
        }

        return strtotime($this->finishDateTime);
    }

    public function getRedirectGoodTitle()
    {
        if (empty($this->redirectGoodId)) {
            return '';
        }

        $good = $this
            ->getRepository()
            ->find(Good::className())
            ->byId($this->redirectGoodId)
            ->one();

        if ($good) {
            return $good->title;
        }

        return '';
    }
}
