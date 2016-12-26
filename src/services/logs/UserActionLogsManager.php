<?php
namespace wajox\yii2base\services\logs;

use wajox\yii2base\components\base\Component;
use wajox\yii2base\models\UserActionLog;

class UserActionLogsManager extends Component
{
    public function __construct($params = [])
    {
        ;
    }

    public function log($typeId, $item = null, $user = null)
    {
        $model = $this->buildModel($user);

        $model->action_type_id = $typeId;
        $model->action_item_id = $item == null ? 0 : $item->id;

        $model->validate();

        return $model->save();
    }

    protected function buildModel($user)
    {
        $model = $this->createObject(UserActionLog::className());

        $visitor = $this->getApp()->visitor;

        $model->user_id = $visitor->userId;
        $model->guid = $visitor->guid;

        if ($user != null) {
            $model->user_id = $user->id;
            $model->guid = $user->guid;
        }

        $model->cookie_id = $visitor->cookieId;
        $model->referal_user_id = $visitor->referalId;
        $model->user_subaccount_id = $visitor->userSubaccountId;
        $model->request_uri = $visitor->requestUri;
        $model->referer_type_id = $visitor->refererTypeId;
        $model->referer_uri = $visitor->refererUri;
        $model->traffic_stream_id = $visitor->trafficStreamId;
        $model->offer_type_id = $visitor->offerTypeId;
        $model->offer_item_id = $visitor->offerItemId;
        $model->ip_address = $visitor->ip;
        $model->country = $visitor->country;
        $model->region = $visitor->region;
        $model->city = $visitor->city;
        $model->created_at = time();

        return $model;
    }

    public function getBillNewLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_NEW_BILL, null, $params);
    }

    public function getBillPayLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_PAY_BILL, null, $params);
    }

    public function getClickNewLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_CLICK_NEW, null, $params);
    }

    public function getVisitNewLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_VISIT_NEW, null, $params);
    }

    public function getOrdersNewLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_NEW_ORDER, null, $params);
    }

    public function getOrderPayLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_PAY_ORDER, null, $params);
    }

    public function getSubscribeNewLogs($params = null)
    {
        return $this->buildQuery(UserActionLog::TYPE_ID_NEW_SUBSCRIBE, null, $params);
    }

    public function buildQuery($typeId = null, $itemId = null, $params = [])
    {
        $q = UserActionLog::find();

        if ($typeId != null) {
            $q = $q->andWhere(['action_type_id' => $typeId]);
        }

        if ($itemId != null) {
            $q = $q->andWhere(['action_item_id' => $itemId]);
        }

        if (sizeof($params) > 0) {
            $q = $q->andWhere($params);
        }

        return $q;
    }
}
