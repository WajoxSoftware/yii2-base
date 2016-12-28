<?php
namespace wajox\yii2base\models;

use wajox\yii2base\models\query\UserActionLogQuery;

class UserActionLog extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const TYPE_ID_NEW_ORDER = 100;
    const TYPE_ID_RETURN_ORDER = 101;
    const TYPE_ID_PAY_ORDER = 102;
    const TYPE_ID_CANCEL_ORDER = 103;
    const TYPE_ID_MONEYBACK_ORDER = 104;
    const TYPE_ID_DELIVER_ORDER = 105;
    const TYPE_ID_UNDELIVER_ORDER = 106;

    const TYPE_ID_NEW_SUBSCRIBE = 200;
    const TYPE_ID_UNSUBSCRIBE = 201;

    const TYPE_ID_SIGN_UP = 300;
    const TYPE_ID_SIGN_IN = 301;
    const TYPE_ID_SIGN_OUT = 302;

    const TYPE_ID_CLICK_NEW = 400;
    const TYPE_ID_VISIT_NEW  = 500;

    const TYPE_ID_GOOD_ORDER = 600;
    const TYPE_ID_GOOD_PAY  = 601;

    const TYPE_ID_NEW_BILL = 700;
    const TYPE_ID_RETURN_BILL = 701;
    const TYPE_ID_PAY_BILL = 702;
    const TYPE_ID_CANCEL_BILL = 703;

    const OFFER_TYPE_ID_NONE = 0;
    const OFFER_TYPE_ID_GOOD = 100;

    public static function tableName()
    {
        return 'user_action_log';
    }

    public function rules()
    {
        return [
            [['guid', 'user_id', 'action_type_id', 'offer_type_id', 'created_at'], 'required'],
            [['user_id', 'referal_user_id', 'referer_type_id', 'user_subaccount_id', 'action_type_id', 'action_item_id', 'traffic_stream_id', 'offer_type_id', 'offer_item_id', 'created_at'], 'integer'],
            [['request_uri', 'referer_uri', 'guid', 'cookie_id', 'ip_address', 'country', 'region', 'city'], 'filter', 'filter' => 'strip_tags'],
            [['request_uri', 'referer_uri', 'guid', 'cookie_id', 'ip_address', 'country', 'region', 'city'], 'filter', 'filter' => 'htmlentities'],
            [['request_uri', 'referer_uri', 'guid', 'cookie_id', 'ip_address', 'country', 'region', 'city'], 'filter', 'filter' => 'trim'],
            [['request_uri', 'referer_uri', 'guid', 'cookie_id', 'ip_address', 'country', 'region', 'city'], 'string', 'max' => 255],
            [['action_type_id'], 'in', 'range' => array_keys(self::getActionTypeIdList())],
            [['offer_type_id'], 'in', 'range' => self::getOfferTypeIdList()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'referal_user_id' => \Yii::t('app/attributes', 'Referal User ID'),
            'userName' => \Yii::t('app/attributes', 'User ID'),
            'referalUserName' => \Yii::t('app/attributes', 'Referal User ID'),
            'actionTitle' => \Yii::t('app/attributes', 'Action Type ID'),
            'action_type_id' => \Yii::t('app/attributes', 'Action Type ID'),
            'action_item_id' => \Yii::t('app/attributes', 'Action Item ID'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public static function find()
    {
        return self::createObject(
            UserActionLogQuery::className(),
            [get_called_class()]
        );
    }

    public static function getOfferTypeIdList()
    {
        return [
            self::OFFER_TYPE_ID_NONE,
            self::OFFER_TYPE_ID_GOOD,
        ];
    }

    public static function getActionTypeIdList()
    {
        return [
            self::TYPE_ID_SIGN_UP => \Yii::t('app/attributes', 'Action Log Type Sign Up'),
            self::TYPE_ID_SIGN_IN => \Yii::t('app/attributes', 'Action Log Type Sign In'),
            self::TYPE_ID_SIGN_OUT => \Yii::t('app/attributes', 'Action Log Type Sign Out'),

            self::TYPE_ID_NEW_BILL => \Yii::t('app/attributes', 'Action Log Type New Bill'),
            self::TYPE_ID_RETURN_BILL => \Yii::t('app/attributes', 'Action Log Type Return Bill'),
            self::TYPE_ID_PAY_BILL => \Yii::t('app/attributes', 'Action Log Type Pay Bill'),
            self::TYPE_ID_CANCEL_BILL => \Yii::t('app/attributes', 'Action Log Type Cancel Bill'),

            self::TYPE_ID_NEW_ORDER => \Yii::t('app/attributes', 'Action Log Type New Order'),
            self::TYPE_ID_RETURN_ORDER => \Yii::t('app/attributes', 'Action Log Type Return Order'),
            self::TYPE_ID_PAY_ORDER => \Yii::t('app/attributes', 'Action Log Type Pay Order'),
            self::TYPE_ID_CANCEL_ORDER => \Yii::t('app/attributes', 'Action Log Type Cancel Order'),
            self::TYPE_ID_MONEYBACK_ORDER => \Yii::t('app/attributes', 'Action Log Type Moneyback Order'),
            self::TYPE_ID_DELIVER_ORDER => \Yii::t('app/attributes', 'Action Log Type Deliver Order'),
            self::TYPE_ID_UNDELIVER_ORDER => \Yii::t('app/attributes', 'Action Log Type Undeliver Order'),

            self::TYPE_ID_NEW_SUBSCRIBE => \Yii::t('app/attributes', 'Action Log Type Subscribe'),
            self::TYPE_ID_UNSUBSCRIBE => \Yii::t('app/attributes', 'Action Log Type Unsubscribe'),

            self::TYPE_ID_CLICK_NEW => \Yii::t('app/attributes', 'Action Log Type Click'),
            self::TYPE_ID_VISIT_NEW => \Yii::t('app/attributes', 'Action Log Type Visit'),

            self::TYPE_ID_GOOD_ORDER => \Yii::t('app/attributes', 'Action Log Type Good Order'),
            self::TYPE_ID_GOOD_PAY => \Yii::t('app/attributes', 'Action Log Type Good Pay'),
        ];
    }

    public function getActionTitle()
    {
        $titles = self::getActionTypeIdList();

        if (isset($titles[$this->action_type_id])) {
            return $titles[$this->action_type_id];
        }

        return;
    }

    public function getIsGoodAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_GOOD_ORDER,
            self::TYPE_ID_GOOD_PAY,
        ]);
    }

    public function getIsBillAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_NEW_BILL,
            self::TYPE_ID_RETURN_BILL,
            self::TYPE_ID_PAY_BILL,
            self::TYPE_ID_CANCEL_BILL,
        ]);
    }

    public function getIsClickAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_CLICK_NEW,
        ]);
    }

    public function getIsVisitAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_VISIT_NEW,
        ]);
    }

    public function getIsUserAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_SIGN_UP,
            self::TYPE_ID_SIGN_IN,
            self::TYPE_ID_SIGN_OUT,
        ]);
    }

    public function getIsOrderAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_NEW_ORDER,
            self::TYPE_ID_RETURN_ORDER,
            self::TYPE_ID_PAY_ORDER,
            self::TYPE_ID_CANCEL_ORDER,
            self::TYPE_ID_MONEYBACK_ORDER,
            self::TYPE_ID_DELIVER_ORDER,
            self::TYPE_ID_UNDELIVER_ORDER,
        ]);
    }

    public function getIsSubscribeAction()
    {
        return in_array($this->action_type_id, [
            self::TYPE_ID_NEW_SUBSCRIBE,
            self::TYPE_ID_UNSUBSCRIBE,
        ]);
    }

    public function getGeo()
    {
        $geo = [];

        if ($this->country) {
            $geo[] = $this->country;
        }

        if ($this->region) {
            $geo[] = $this->region;
        }

        if ($this->city) {
            $geo[] = $this->city;
        }

        $geo[] = $this->ip_address;

        return implode(', ', $geo);
    }

    public function getUser()
    {
        return $this
            ->getRepository()
            ->find(User::className())
            ->byIdOrGuid($this->user_id, $this->guid)
            ->one();
    }

    public function getReferalUser()
    {
        return $this
            ->getRepository()
            ->find(User::className())
            ->byId($this->referal_user_id)
            ->one();
    }

    public function getBill()
    {
        if (!$this->isBillAction) {
            return;
        }

        return $this
            ->getRepository()
            ->find(Bill::className())
            ->byId($this->action_item_id)
            ->one();
    }

    public function getVisit()
    {
        if (!$this->isVisitAction) {
            return;
        }

        return $this
            ->getRepository()
            ->find(Statistic::className())
            ->byId($this->action_item_id)
            ->one();
    }

    public function getGood()
    {
        if (!$this->isGoodAction) {
            return;
        }

        return $this
            ->getRepository()
            ->find(Good::className())
            ->byId($this->action_item_id)
            ->one();
    }

    public function getOrder()
    {
        if (!$this->isOrderAction) {
            return;
        }

        return $this
            ->getRepository()
            ->find(Order::className())
            ->byId($this->action_item_id)
            ->one();
    }

    public function getEmailList()
    {
        if (!$this->isSubscribeAction) {
            return;
        }

        return $this
            ->getRepository()
            ->find(EmailList::className())
            ->byId($this->action_item_id)
            ->one();
    }
}
