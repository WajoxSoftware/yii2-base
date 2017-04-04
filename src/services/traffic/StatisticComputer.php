<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\components\base\Object;
use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\models\PartnerFee;

class StatisticComputer extends Object
{
    protected $user;
    protected $params;

    public function __construct($user = null, $params = [])
    {
        $this->setUser($user)->setParams($params);
    }

    public function getIsPartner()
    {
        if ($this->getUser() == null) {
            return false;
        }

        return $this->getUser()->hasPartnerAccount;
    }

    public function getPartner()
    {
        if ($this->getIsPartner()) {
            return $this->getUser()->partner;
        }

        return;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function fetch($start_date, $finish_date)
    {
        $params = $this->getAllParams();

        $start_time = is_numeric($start_date) ? $start_date : strtotime($start_date);
        $finish_time = is_numeric($finish_date) ? $finish_date : strtotime($finish_date);

        $time_cond = ['start' => $start_time, 'finish' => $finish_time];

        $visitsCount = $this
            ->getApp()
            ->actionLogs
            ->getVisitNewLogs($params)
            ->andWhere('created_at >= :start AND created_at < :finish', $time_cond)
            ->count();

        $uniqueVisitsCount = $this
            ->getApp()
            ->actionLogs
            ->getVisitNewLogs($params)
            ->andWhere('created_at >= :start AND created_at < :finish', $time_cond)
            ->select('[[ip_address]]')
            ->groupBy('[[ip_address]]')
            ->count();

        $subscribesCount = $this
            ->getApp()
            ->actionLogs
            ->getSubscribeNewLogs($params)
            ->andWhere('created_at >= :start AND created_at < :finish', $time_cond)
            ->count();

        $newBillLogs = $this
            ->getApp()
            ->actionLogs
            ->getBillNewLogs($params)
            ->andWhere('created_at >= :start AND created_at < :finish', $time_cond)
            ->indexBy('item_id')
            ->all();

        $paidBillLogs = $this
            ->getApp()
            ->actionLogs
            ->getBillPayLogs($params)
            ->andWhere('created_at >= :start AND created_at < :finish', $time_cond)
            ->indexBy('item_id')
            ->all();

        $newBillIds = array_keys($newBillLogs);
        $paidBillIds = array_keys($paidBillLogs);

        $billsNewQ = $this
            ->getRepository()
            ->find(Bill::className())
            ->byIds($newBillIds);

        $billsPaidQ = $this
            ->getRepository()
            ->find(Bill::className())
            ->byIds($paidBillIds);

        $newBillsCount = sizeof($newBillIds);
        $paidBillsCount = sizeof($paidBillIds);
        $paidBillsSum = $billsPaidQ->sum('[[sum]]');

        $cond['status_id'] = array_keys(PartnerFee::getActiveStatusIdList());

        if ($this->getIsPartner()) {
            $cond['partner_id'] = $this->getPartner()->id;
        }

        $partnersFeeSum = $this
            ->getRepository()
            ->find(PartnerFee::className())
            ->where($cond)
            ->andWhere(
                'created_at >= :start AND created_at < :finish',
                $time_cond
            )
            ->sum('[[sum]]');

        if ($this->getIsPartner()) {
            $profitSum = $partnersFeeSum;
        } else {
            $profitSum = $paidBillsSum - $partnersFeeSum;
        }

        $eCpc = 0;
        $conversion = 0;
        if ($uniqueVisitsCount > 0) {
            $eCpc = $profitSum / $uniqueVisitsCount;
            $conversion = $paidBillsCount / $uniqueVisitsCount * 100;
        }

        return [
            'visitsCount' => number_format($visitsCount),
            'uniqueVisitsCount' => number_format($uniqueVisitsCount),
            'newSubscribesCount' => number_format($subscribesCount),
            'newBillsCount' => number_format($newBillsCount),
            'payBillsCount' => number_format($paidBillsCount),
            'payBillsSum' => number_format($paidBillsSum, 2),
            'partnersFeeSum' => number_format($partnersFeeSum, 2),
            'profitSum' => number_format($profitSum, 2),
            'eCpc' => number_format($eCpc, 2),
            'conversion' => number_format($conversion, 2) . '%',
        ];
    }

    protected function getAllParams()
    {
        $params = $this->getParams();

        if ($this->getUser() != null) {
            $userParams = [
                'referal_user_id' => $this->getUser()->id,
            ];
            $params = array_merge($params, $userParams);
        }

        return $params;
    }
}
