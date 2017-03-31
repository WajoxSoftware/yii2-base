<?php
namespace wajox\yii2base\modules;

abstract class ModuleAbstract extends \yii\base\Module
{
    use \wajox\yii2base\traits\AppTrait;
    use \wajox\yii2base\traits\DiContainerTrait;
    use \wajox\yii2base\traits\I18nTrait;

    public $hasSessionController = false;
    public $hasRegistrationController = false;
    public $layouts = [];

    public function init()
    {
        parent::init();
        $this->initModule();
    }

    protected function initModule()
    {
        $this->getApp()->user->loginUrl = ['/'.$this->id.'/session'];
    }

    public function getModuleHomeBreadcrumbs()
    {
        return [
            'label' => $this->t('app/'.$this->id, 'Module Home'),
            'url' => ['/'.$this->id],
        ];
    }

    public function beforeAction($action)
    {
        $this->setLayoutByControllerId($action->controller->id);

        return parent::beforeAction($action);
    }

    protected function setLayoutByControllerId($controllerId)
    {
        if (sizeof($this->layouts) == 0) {
            return;
        }

        $parts = explode('/', $controllerId);
        $layoutId = sizeof($parts) > 1 ? array_shift($parts) : 'default';

        if (isset($layouts[$layoutId])) {
            $this->layout = $layouts[$layoutId];
        }
    }
}
