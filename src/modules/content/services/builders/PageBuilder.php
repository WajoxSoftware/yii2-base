<?php
namespace wajox\yii2base\modules\content\services\builders;

use wajox\yii2base\modules\content\models\form\PageForm;

class PageBuilder extends ContentNodeBuilderAbstract
{
	protected function createForm()
    {
        $this->setForm($this->createObject(PageForm::className()));

        return $this;
    }
}