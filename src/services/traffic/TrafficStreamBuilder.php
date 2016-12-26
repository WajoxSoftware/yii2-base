<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\TrafficStreamGood;
use wajox\yii2base\models\TrafficCompany;
use wajox\yii2base\services\web\UrlConverter;
use wajox\yii2base\components\base\Object;

class TrafficStreamBuilder extends Object
{
    const TRAFFIC_MODE_GOOD = 100;
    const TRAFFIC_MODE_COMPANY = 101;

    protected $model;
    protected $modelCompany;
    protected $modelGood;
    protected $source;
    protected $request;
    protected $trafficMode;

    public function __construct($source, $model = null)
    {
        $this->setSource($source)->setModel($model);
    }

    public function save($request)
    {
        try {
            $this->build()
                 ->loadRequest($request)
                 ->validate()
                 ->store();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function build()
    {
        return $this->buildModel()
            ->buildModelGood()
            ->buildModelCompany();
    }

    public function validate()
    {
        return $this->validateModel()
            ->validateModelGood()
            ->validateModelCompany();
    }

    public function store()
    {
        return $this->saveModel()
            ->saveModelGood()
            ->saveModelCompany();
    }

    public function setTrafficModeGood()
    {
        $this->trafficMode = self::TRAFFIC_MODE_GOOD;

        return $this;
    }

    public function setTrafficModeCompany()
    {
        $this->trafficMode = self::TRAFFIC_MODE_COMPANY;

        return $this;
    }

    public function getTrafficModeGoodEnabled()
    {
        return $this->trafficMode == self::TRAFFIC_MODE_GOOD;
    }

    public function getTrafficModeCompanyEnabled()
    {
        return $this->trafficMode == self::TRAFFIC_MODE_COMPANY;
    }

    public function getUser()
    {
        return $this->getSource()->user;
    }

    public function setSource($source)
    {
        $this->source = $source;

        if ($this->getUser()->hasTrafficAccount) {
            $this->setTrafficModeCompany();
        }

        if ($this->getUser()->hasPartnerAccount) {
            $this->setTrafficModeGood();
        }

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setModel($model)
    {
        if ($model == null) {
            $model = $this->createObject(TrafficStream::className());
        }

        $this->model = $model;

        if ($model->trafficCompany != null) {
            $this->setModelCompany($model->trafficCompany);
        }

        if ($model->trafficGood != null) {
            $this->setModelGood($model->trafficGood);
        }

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getModelCompany()
    {
        return $this->modelCompany;
    }

    public function getModelGood()
    {
        return $this->modelGood;
    }

    protected function setModelCompany($modelCompany)
    {
        $this->modelCompany = $modelCompany;

        return $this;
    }

    protected function setModelGood($modelGood)
    {
        $this->modelGood = $modelGood;

        return $this;
    }

    protected function loadRequest($request)
    {
        $this->request = $request;

        $this->model->load($request->post());

        if ($this->getTrafficModeCompanyEnabled()) {
            $this->modelCompany->load($this->request->post());
        }

        if ($this->getTrafficModeGoodEnabled()) {
            $this->modelGood->load($this->request->post());

            $good = Good::findOne($this->modelGood->good_id);

            if ($good == null) {
                throw new \Exception('Good not found');
            }

            $this->model->target_url = $this->createObject(UrlConverter::className())->buildClass($good);
        }

        return $this;
    }

    protected function buildModel()
    {
        if ($this->getModel() == null) {
            $this->setModel($this->createObject(TrafficStream::className()));
        }

        $this->model->user_id = $this->getUser()->id;
        $this->model->traffic_source_id = $this->getSource()->id;

        return $this;
    }

    protected function buildModelCompany()
    {
        if (!$this->getTrafficModeCompanyEnabled()) {
            return $this;
        }

        if ($this->getModelCompany() == null) {
            $this->setModelCompany($this->createObject(TrafficCompany::className()));
        }

        $this->modelCompany->traffic_stream_id = 0;

        return $this;
    }

    protected function buildModelGood()
    {
        if (!$this->getTrafficModeGoodEnabled()) {
            return $this;
        }

        if ($this->getModelGood() == null) {
            $this->setModelGood($this->createObject(TrafficStreamGood::className()));
        }

        $this->modelGood->traffic_stream_id = 0;
        $this->model->target_url = 'good://0';

        return $this;
    }

    protected function saveModel()
    {
        if (!$this->model->save()) {
            throw new \Exception('Can not save traffic stream model');
        }

        return $this;
    }

    protected function saveModelCompany()
    {
        if (!$this->getTrafficModeCompanyEnabled()) {
            return $this;
        }

        $this->modelCompany->traffic_stream_id = $this->getModel()->id;

        if (!$this->modelCompany->save()) {
            throw new \Exception('Can not save traffic stream company model');
        }

        return $this;
    }

    protected function saveModelGood()
    {
        if (!$this->getTrafficModeGoodEnabled()) {
            return $this;
        }

        $this->modelGood->traffic_stream_id = $this->getModel()->id;

        if (!$this->modelGood->save()) {
            throw new \Exception('Can not save traffic stream good model');
        }

        return $this;
    }

    protected function validateModel()
    {
        if (!$this->getModel()->validate()) {
            throw new \Exception('Can not validate traffic stream model');
        }

        return $this;
    }

    protected function validateModelCompany()
    {
        if (!$this->getTrafficModeCompanyEnabled()) {
            return $this;
        }

        if (!$this->getModelCompany()->validate()) {
            throw new \Exception('Can not validate traffic stream company model');
        }

        return $this;
    }

    protected function validateModelGood()
    {
        if (!$this->getTrafficModeGoodEnabled()) {
            return $this;
        }

        if (!$this->getModelGood()->validate()) {
            throw new \Exception('Can not validate traffic stream good model');
        }

        return $this;
    }
}
