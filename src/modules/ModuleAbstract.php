<?php
namespace wajox\yii2base\modules;

abstract class ModuleAbstract extends \yii\base\Module
{
    use \wajox\yii2base\traits\AppTrait;
    use \wajox\yii2base\traits\DiContainerTrait;
    use \wajox\yii2base\traits\I18nTrait;

    public $hasSessionController = false;
    public $hasRegistrationController = false;

    public function init()
    {
        parent::init();
        $this->initModule();
    }

    protected function initModule()
    {
        $this->controllerNamespace = 'app\modules\\'.$this->id.'\controllers';
        $this->layout = 'profile';
        $this->getApp()->user->loginUrl = ['/'.$this->id.'/session'];
    }

    public function getModuleHomeBreadcrumbs()
    {
        return [
            'label' => $this->t('app/'.$this->id, 'Module Home'),
            'url' => ['/'.$this->id],
        ];
    }
}
