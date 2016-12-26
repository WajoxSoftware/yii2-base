<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\models\Statistic;
use wajox\yii2base\services\events\types\StatisticEvent;
use wajox\yii2base\components\base\Object;

class StatisticManager extends Object
{
    public function save($request)
    {
        $model = $this->buildModel();
        $model->load($request->post());

        if ($model->save()) {
            $this->getApp()->visitor->setRequestUri($model->page_url);
            $this->triggerEventNew($model);
        }

        return $model;
    }

    protected function buildModel()
    {
        $visitor = $this->getApp()->visitor;

        $model = $this->createObject(Statistic::className());
        $model->user_id = $visitor->userId;
        $model->guid = $visitor->guid;
        $model->created_at = time();

        return $model;
    }

    protected function triggerEventNew($model)
    {
        $event = $this->createObject(StatisticEvent::className());
        $event->statistic = $model;
        $this->getApp()->eventsManager->trigger(
            Statistic::className(),
            StatisticEvent::EVENT_NEW,
            $event
        );
    }
}
