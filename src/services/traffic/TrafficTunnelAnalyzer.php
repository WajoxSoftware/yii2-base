<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\components\base\Object;

class TrafficTunnelAnalyzer extends Object
{
    protected $startDate;
    protected $finishDate;
    protected $model;
    protected $sources = [];
    protected $data = [];

    public function __construct($model, $startDate, $finishDate)
    {
        $this->setModel($model)
            ->setStartDate($startDate)
            ->setFinishDate($finishDate)
            ->clearData()
            ->clearSources();
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    public function getFinishDate()
    {
        return $this->finishDate;
    }

    public function setSources($sources)
    {
        $this->sources = $sources;

        return $this;
    }

    public function getSources()
    {
        return $this->sources;
    }

    public function clearSources()
    {
        $this->sources = [];

        return $this;
    }

    public function clearData()
    {
        $this->data = [];

        return $this;
    }

    public function loadData()
    {
        $data = [];
        foreach ($this->getSources() as $i => $source) {
            $where = isset($source['where']) ? $source['where'] : [];
            $data[$i] = [
                'title' => $source['title'],
                'steps' => $this->computeSourceData($where),
            ];
        }

        $this->setData($data);

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    protected function getStartAt()
    {
        return strtotime($this->getStartDate());
    }

    protected function getFinishAt()
    {
        return strtotime($this->getFinishDate());
    }

    protected function computeSourceData($sourceWhere)
    {
        $data = [];

        foreach ($this->getModel()->steps as $step) {
            $q = $this->getStepDataQuery($step);
            if (sizeof($sourceWhere) > 0) {
                $q = $q->andWhere($sourceWhere);
            }

            $data[$step->id] = $q->count();
        }

        return $data;
    }

    protected function getStepDataQuery($step)
    {
        $where['action_type_id'] = $step->action_type_id;

        if ($step->action_type_id == UserActionLog::TYPE_ID_VISIT_NEW) {
            $where['request_uri'] = $step->action_params;
        } elseif (!empty($step->action_params)) {
            $where['action_item_id'] = $step->action_params;
        }

        return $this
            ->getRepository()
            ->find(UserActionLog::className())
            ->andWhere(['>', 'created_at', $this->getStartAt()])
            ->andWhere(['<', 'created_at', $this->getFinishAt()])
            ->where($where);
    }
}
