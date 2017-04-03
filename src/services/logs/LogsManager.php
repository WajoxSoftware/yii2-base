<?php
namespace wajox\yii2base\services\logs;

use wajox\yii2base\components\base\Component;
use wajox\yii2base\models\Log;
use wajox\yii2base\models\LogParam;

class LogsManager extends Component
{
    public function __construct($params = [])
    {
        ;
    }

    public function log($typeId, $itemId = null, $user = null, $params = [])
    {
        $cmdParams = [
            $typeId,
            $itemId,
            $user ? $user->id : null,
            json_encode($params),
        ];

        \Yii::$app
            ->commands
            ->run(
                'action-logs/create',
                $cmdParams,
                true
            );
    }

    public function saveLog($typeId, $itemId = null, $userId = null, $params = [])
    {
        $user = $userId ? $userId : \Yii::$app->usersManager->findById($userId);
        
        $model = $this->buildModel($user);

        $model->type_id = $typeId;
        $model->item_id = $itemId;

        $model->validate();

        $ta = \Yii::$app->db->beginTransaction();

        try {
            if (!$model->save()) {
                throw new \Exception('Can not save model');
            }

            $this->saveParams($model, $params);    
        } catch (\Exception $e) {
            $ta->rollBack();
        }

        $ta->commit();

        return true;  
    }

    protected function buildModel($user)
    {
        $model = $this->createObject(Log::className());

        $visitor = $this->getApp()->visitor;

        $model->user_id = $visitor->userId;
        $model->guid = $visitor->guid;

        if ($user != null) {
            $model->user_id = $user->id;
            $model->guid = $user->guid;
        }

        $model->cookie_id = $visitor->cookieId;
        $model->referal_user_id = $visitor->referalId;
        $model->request_uri = $visitor->requestUri;
        $model->referer_type_id = $visitor->refererTypeId;
        $model->referer_uri = $visitor->refererUri;
        $model->ip_address = $visitor->ip;
        $model->country = $visitor->country;
        $model->region = $visitor->region;
        $model->city = $visitor->city;
        $model->created_at = time();

        return $model;
    }

    public function getBillNewLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_NEW_BILL, null, $params);
    }

    public function getBillPayLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_PAY_BILL, null, $params);
    }

    public function getClickNewLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_CLICK_NEW, null, $params);
    }

    public function getVisitNewLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_VISIT_NEW, null, $params);
    }

    public function getOrdersNewLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_NEW_ORDER, null, $params);
    }

    public function getOrderPayLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_PAY_ORDER, null, $params);
    }

    public function getSubscribeNewLogs($params = null)
    {
        return $this->buildQuery(Log::TYPE_ID_NEW_SUBSCRIBE, null, $params);
    }

    public function buildQuery($typeId = null, $itemId = null, $params = [])
    {
        $q = $this
            ->getRepository()
            ->find(Log::className());

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

    protected function saveParams($model, $params = [])
    {
        $defaultParams = [
            LogParam::PARAM_TRAFFIC_STREAM_Id => $visitor->trafficStreamId,
            LogParam::PARAM_ID_OFFER_TYPE_ID => $visitor->offerTypeId,
            LogParam::PARAM_ID_OFFER_ITEM_ID => $visitor->offerItemId,
        ];

        $params = array_merge($defaultParams, $params);

        foreach ($params as $paramId => $value) {
            $this->saveParam($model, $paramId, $value);
        }
    }

    protected function saveParam($parent, $paramId, $value)
    {
        $model = $this->createObject(LogParam::className());
        $model->log_id = $parent->id;
        $model->param_id = $paramId;

        if (is_integer($value)) {
            $model->int_value = $value;
        } else {
            $model->string_value = $value;
        }

        if (!$model->save()) {
            throw new \Exception('Can not save param');
        }
    }
}
