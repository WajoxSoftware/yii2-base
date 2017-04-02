<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\helpers\DateTimeHelper;
use wajox\yii2base\models\TrafficStreamPrice;
use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\components\base\Object;

class TrafficStreamStatisticAnalyzer extends Object
{
    public $model = null;
    public $interval = 'today';
    public $start_date = '01.01.1970';
    public $finish_date = '01.01.1970';
    public $start_time = 0;
    public $finish_time = 0;
    public $clicksCount = 0;
    public $subscribesCount = 0;
    public $ecpc = 0.0;
    public $cpc = 0.0;
    public $roi = 0;
    public $billSum = 0.0;
    public $clicksSum = 0.0;
    public $paidClicksCount = 0;
    public $extParams = [];

    public function __construct($model, $interval = 'today', $custom_start_date = null, $custom_finish_date = null, $extParams = [])
    {
        $this->computeIntervals($interval, $custom_start_date, $custom_finish_date);
        $this->model = $model;
        $this->extParams = $extParams;
    }

    public function compute()
    {
        $this->computeClicksCount();
        $this->computeSubscribesCount();
        $this->computeBillsSum();
        $this->computeClicksSum();
        $this->computeExtParams();

        return [
            'clicks_count' => $this->clicksCount,
            'subscribes_count' => $this->subscribesCount,
            'ecpc' => number_format($this->ecpc, 2),
            'cpc' => number_format($this->cpc, 2),
            'roi' => number_format($this->roi, 2),
            'bill_sum' => number_format($this->billSum, 2),
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'start_time' => $this->start_time,
            'finish_time' => $this->finish_time,

          ];
    }

    protected function getTimeCond()
    {
        return [
            'start' => $this->start_time,
            'finish' => $this->finish_time,
        ];
    }

    protected function computeClicksCount()
    {
        $this->clicksCount = $this->getApp()->userActionLogs->getClickNewLogs($this->extParams)
            ->andWhere(['traffic_stream_id' => $this->model->id])
            ->andWhere('[[created_at]] >= :start AND [[created_at]] < :finish', $this->getTimeCond())
            ->count();
    }

    protected function computeSubscribesCount()
    {
        $this->subscribesCount = $this->getApp()->userActionLogs->getSubscribeNewLogs($this->extParams)
            ->andWhere(['traffic_stream_id' => $this->model->id])
            ->andWhere('[[created_at]] >= :start AND [[created_at]] < :finish', $this->getTimeCond())
            ->count();
    }

    protected function computeBillsSum()
    {
        $traffic_stream_id = $this->model->id;
        $billLogs = $this->getApp()->userActionLogs->getBillPayLogs($this->extParams)
            ->andWhere(['traffic_stream_id' => $this->model->id])
            ->andWhere('[[created_at]] >= :start AND [[created_at]] < :finish', $this->getTimeCond())
            ->indexBy('id');

        $billIds = [];

        foreach ($billLogs->each() as $billLog) {
            $billIds[] = $billLog->action_item_id;
        }

        $this->billSum = $this
            ->getRepository()
            ->find(Bill::className())
            ->where(['id' => $billIds])
            ->sum('[[sum]]');
    }

    protected function computeClicksSum()
    {
        $cond = [
            'stream' => $this->model->id,
            'start' => $this->start_time,
            'finish' => $this->finish_time,
          ];
        $query = $this
            ->getRepository()
            ->find(TrafficStreamPrice::className())
            ->where(
                '[[traffic_stream_id]] = :stream AND [[started_at]] >= :start AND [[finished_at]] < :finish',
                $cond
            )
            ->orWhere(
                '[[traffic_stream_id]] = :stream AND [[started_at]] = 0 AND [[finished_at]] = 0',
                $cond
            );

        $this->clicksSum = $query->sum('[[sum]]');

        $this->paidClicksCount = $query->sum('[[clicks_count]]');
    }

    protected function computeIntervals($interval, $custom_start_date, $custom_finish_date)
    {
        $computedIntervals = DateTimeHelper::computeIntervals($interval, $custom_start_date, $custom_finish_date);
        $this->interval = $computedIntervals['interval'];
        $this->start_date = $computedIntervals['start_date'];
        $this->finish_date = $computedIntervals['finish_date'];

        $this->start_time = strtotime($this->start_date);
        $this->finish_time = strtotime($this->finish_date);
    }

    protected function computeExtParams()
    {
        $ecpc = 0;
        $cpc = 0;
        $roi = 0;

        if ($this->clicksCount > 0) {
            $ecpc = $this->billSum / $this->clicksCount;
        }

        if ($this->paidClicksCount > 0) {
            $cpc = $this->clicksSum / $this->paidClicksCount;
        }

        if ($cpc > 0) {
            $roi = $ecpc / $cpc * 100;
        }

        $this->ecpc = $ecpc;
        $this->cpc = $cpc;
        $this->roi = $roi;
    }
}
