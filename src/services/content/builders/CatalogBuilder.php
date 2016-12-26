<?php
namespace wajox\yii2base\services\content\builders;

use wajox\yii2base\models\form\content\CatalogForm;

class CatalogBuilder extends ContentNodeBuilderAbstract
{
	protected function createForm()
    {
        $this->setForm($this->createObject(CatalogForm::className()));

        return $this;
    }
}