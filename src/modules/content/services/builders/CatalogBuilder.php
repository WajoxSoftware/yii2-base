<?php
namespace wajox\yii2base\modules\content\services\builders;

use wajox\yii2base\modules\content\models\form\CatalogForm;

class CatalogBuilder extends ContentNodeBuilderAbstract
{
	protected function createForm()
    {
        $this->setForm($this->createObject(CatalogForm::className()));

        return $this;
    }
}