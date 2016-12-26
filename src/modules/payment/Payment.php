<?php
namespace wajox\yii2base\modules\payment;

class Payment extends \wajox\yii2base\modules\ModuleAbstract
{
    protected function initModule()
    {
        parent::initModule();
        $this->layout = 'main';
    }
}
