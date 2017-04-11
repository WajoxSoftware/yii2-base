<?php
namespace wajox\yii2base\modules\shop\services\goods\builders;

use wajox\yii2base\modules\shop\models\form\goods\PhysicalGoodForm;

class GoodsBuilderPhysical extends GoodsBuilderAbstract
{
    public function createForm()
    {
        $this->setForm(
            $this->createObject(
                PhysicalGoodForm::className()
            )
        );

        return $this;
    }

    protected function getGoodTypeId()
    {
        return \wajox\yii2base\modules\shop\models\Good::TYPE_ID_PHYSICAL;
    }
}
