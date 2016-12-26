<?php
namespace wajox\yii2base\services\shop;

use wajox\yii2base\models\Good;
use wajox\yii2base\components\base\Object;

class GoodsManager extends Object
{
    public $model = null;
    public $user = null;

    public function __construct($user, $model)
    {
        $this->setUser($user)->setModel($model);
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model == null ? $this->createObject(Good::className()) : $model;

        return $this;
    }

    public function getParent()
    {
        if ($this->model->parent_good_id == 0) {
            return;
        }

        return Good::findOne($this->model->parent_good_id);
    }

    public function getBuilder()
    {
        $buildersList = $this->getBuildersList();

        if (!isset($buildersList[$this->model->good_type_id])) {
            throw new \Exception('Unknown good type');
        }

        $className = $buildersList[$this->model->good_type_id];

        return $this->createObject($className, [$this->user, $this->model]);
    }

    public function getDraftsBuilder($source = null, $cloneMode = false)
    {
        return $this->createObject(GoodDraftsBuilder::className(), [$this->user, $source, $cloneMode]);
    }

    public function delete()
    {
        return $this->model->delete();
    }

    public function getBuildersList()
    {
        return [
            Good::TYPE_ID_ELECTRONIC => \wajox\yii2base\services\shop\goods\builders\GoodsBuilderElectronic::className(),
            Good::TYPE_ID_PHYSICAL => \wajox\yii2base\services\shop\goods\builders\GoodsBuilderPhysical::className(),
        ];
    }
}
