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

    protected $moduleNamespace;
    protected $moduleHomeBreadcrumbs = [];

    public function init()
    {
        parent::init();
        $this->initModule();
    }

    protected function initModule()
    {
        $this
            ->getApp()
            ->user
            ->loginUrl = ['/'.$this->id.'/session'];
    }

    public function getModuleHomeBreadcrumbs()
    {
        return $this->moduleHomeBreadcrumbs;
    }

    public function beforeAction($action)
    {
        $this
            ->loadModuleNamespace($action->controller->id)
            ->setModuleLayout()
            ->setModuleHomeBreadcrumbs();

        return parent::beforeAction($action);
    }

    protected function setModuleLayout()
    {
        if (sizeof($this->layouts) == 0) {
            return $this;
        }

        $layoutId = $this->moduleNamespace ?
            $this->moduleNamespace : 'default';

        if (isset($this->layouts[$layoutId])) {
            $this->layout = $this->layouts[$layoutId];
        }

        return $this;
    }

    protected function setModuleHomeBreadcrumbs()
    {
        $moduleNamespace = $this->moduleNamespace ?
            '/' . $this->moduleNamespace . '/default/index' : '';

        $this->moduleHomeBreadcrumbs = [
            'label' => $this->t('app/'.$this->id, 'Module Home'),
            'url' => ['/'. $this->id . $moduleNamespace],
        ];

        return $this;
    }

    protected function loadModuleNamespace($controllerId)
    {
        $parts = explode('/', $controllerId);

        $this->moduleNamespace = sizeof($parts) > 1 ? array_shift($parts) : null;

        return $this;
    }
}
