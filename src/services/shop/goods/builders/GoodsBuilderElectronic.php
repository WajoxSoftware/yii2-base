<?php
namespace wajox\yii2base\services\shop\goods\builders;

use wajox\yii2base\models\form\goods\ElectronicGoodForm;

class GoodsBuilderElectronic extends GoodsBuilderAbstract
{
    public function createForm()
    {
        $this->setForm(
        	$this->createObject(
        		ElectronicGoodForm::className()
        	)
        );

        return $this;
    }

    protected function getGoodTypeId()
    {
    	return \wajox\yii2base\models\Good::TYPE_ID_ELECTRONIC;
    }
}
