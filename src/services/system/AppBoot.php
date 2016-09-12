<?php
namespace wajox\yii2base\services\system;

use wajox\yii2base\components\base\Component;

class AppBoot extends Component
{
    const APP_BASE_THEME = 'base';

    public function __construct()
    {
        $this->initAppSettings();
    }

    protected function initAppSettings()
    {
        $theme = $this->getApp()->settings->get('app_theme', 'base');
        $indexUrl = $this->getApp()->settings->get('app_index_url', 'site/index');

        $this->setupAppTheme($theme);
        $this->setupAppIndexUrl($indexUrl);
    }

    protected function setupAppTheme($theme)
    {
        $this->getApp()->view->theme->basePath = '@themes/' . $theme;
        $this->getApp()>view->theme->baseUrl = '@themes/' . $theme;

        $this->getApp()->view->theme->pathMap = [
                '@app/views' => [
                        '@themes/' . $theme . '/views',
                        '@themes/' . self::APP_BASE_THEME . '/views',
                    ],
                '@app/modules' => [

                        '@themes/' . $theme . '/modules',
                        '@themes/' . self::APP_BASE_THEME. '/modules',
                    ],
                '@app/mail' => [
                        '@themes/' . $theme . '/mail',
                        '@themes/' . self::APP_BASE_THEME . '/mail',
                    ],
                '@app/widgets' => [
                        '@themes/' . $theme . '/widgets',
                        '@themes/' . self::APP_BASE_THEME . '/widgets',
                    ],
            ];
    }

    protected function setupAppIndexUrl($indexUrl)
    {
        $this->getApp()->urlManager->addRules(['/' => $indexUrl], false);
    }

    protected function add($model)
    {
        $this->items[$model->key] = $model;

        return $this;
    }
}
