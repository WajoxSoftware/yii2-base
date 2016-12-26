<?php

namespace wajox\yii2base\modules\shop;

class Shop extends \wajox\yii2base\modules\ModuleAbstract
{
    protected function initModule()
    {
        parent::initModule();
        $this->layout = 'main';
    }
}
