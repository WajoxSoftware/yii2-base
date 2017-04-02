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
    protected $model;
    protected $source;
    protected $stream;
    protected $request;

    public function __construct($source, $stream, $model = null)
    {
        $this
            ->setSource($source)
            ->setStream($stream)
            ->setModel($model);
    }

    public function save($request)
    {
        $ta = \Yii::$app->db->beginTransaction();

        try {
            $this
                ->build()
                ->loadRequest($request)
                ->validate()
                ->store();
        } catch (\Exception $e) {
            $ta->rollBack();
            return false;
        }

        $ta->commit();

        return true;
    }

    public function build()
    {
        return $this->buildModel();
    }

    public function validate()
    {
        return $this->validateModel();
    }

    public function store()
    {
        return $this->saveModel();
    }

    public function getUser()
    {
        return $this->getSource()->user;
    }

    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setModel($model)
    {
        if ($model == null) {
            $model = $this->createObject(TrafficStream::className());
        }

        $this->model = $model;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function loadRequest($request)
    {
        $this->request = $request;
        $this->model->load($request->post());
        $this->loadModelParams();

        return $this;
    }

    protected function buildModel()
    {
        if ($this->getModel() == null) {
            $this->setModel($this->createObject(TrafficStream::className()));
        }
    
        return $this;
    }

    protected function loadModelParams()
    {
        $this->model->user_id = $this->getUser()->id;
        $this->model->traffic_source_id = $this->getSource()->id;
        $this->model->parent_id = $this->getParentId();
        $this->model->parent_ids = $this->getParentIds();
        $this->model->level = $this->getLevel();
        $this->model->full_tag = $this->getFullTag();

        return $this;
    }

    protected function saveModel()
    {
        if (!$this->model->save()) {
            throw new \Exception('Can not save traffic stream model');
        }

        return $this;
    }

    protected function validateModel()
    {
        if (!$this->getModel()->validate()) {
            print_r($this->getModel()->errors);die();
            throw new \Exception('Can not validate traffic stream model');
        }

        return $this;
    }

    protected function getLevel()
    {
        if ($this->getStream() == null) {
            return 0;
        }

        return $this->getStream()->level + 1;
    }

    protected function getFullTag()
    {
        if ($this->getStream() == null) {
            return $this->model->tag;
        }

        $tags = $this->getStream()->tags;
        $tags[] = $this->model->tag;

        return implode('/', $tags);
    }

    protected function getParentIds()
    {
        if ($this->getStream() == null) {
            return '';
        }

        $parentIds = $this->getStream()->parentIds;
        $parentIds[] = $this->getStream()->id;

        return implode(',', $parentIds);
    }

    protected function getParentId()
    {
        if ($this->getStream() == null) {
            return 0;
        }

        return $this->getStream()->id;
    }
}
