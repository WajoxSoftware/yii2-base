<?php
namespace wajox\yii2base\services\system;

use yii\base\Component;

class AppBoot extends Component
{
    const APP_BASE_THEME = 'base';

    public function __construct()
    {
        $this->initAppSettings();
    }

    protected function initAppSettings()
    {
        $theme = \Yii::$app->settings->get('app_theme', 'base');
        $indexUrl = \Yii::$app->settings->get('app_index_url', 'site/index');

        $this->setupAppTheme($theme);
        $this->setupAppIndexUrl($indexUrl);
    }

    protected function setupAppTheme($theme)
    {
        \Yii::$app->view->theme->basePath = '@themes/' . $theme;
        \Yii::$app->view->theme->baseUrl = '@themes/' . $theme;

        \Yii::$app->view->theme->pathMap = [
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
        \Yii::$app->urlManager->addRules(['/' => $indexUrl], false);
    }

    protected function add($model)
    {
        $this->items[$model->key] = $model;

        return $this;
    }
}
