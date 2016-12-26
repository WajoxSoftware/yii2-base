<?php
namespace wajox\yii2base\services\content\builders;

use wajox\yii2base\models\form\content\PageForm;

class PageBuilder extends ContentNodeBuilderAbstract
{
	protected function createForm()
    {
        $this->setForm($this->createObject(PageForm::className()));

        return $this;
    }
}