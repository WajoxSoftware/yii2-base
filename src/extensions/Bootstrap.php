<?php
namespace wajox\yii2base\extensions;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use wajox\yii2base\components\base\Component;

class Bootstrap extends Component implements BootstrapInterface
{
    const APP_BASE_THEME = 'base';

    public function bootstrap($app)
    {
        $this->initAppSettings($app);
    }

    protected function initAppSettings($app)
    {
        $theme = $app->settings->get('app_theme', 'base');
        $indexUrl = $app->settings->get('app_index_url', 'site/index');

        $this->setupAppTheme($theme, $app);
        $this->setupAppIndexUrl($indexUrl, $app);
    }

    protected function setupAppTheme($theme, $app)
    {
        $app->view->theme->basePath = '@themes/' . $theme;
        $app->view->theme->baseUrl = '@themes/' . $theme;

        $app->view->theme->pathMap = [
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

    protected function setupAppIndexUrl($indexUrl, $app)
    {
        $app->urlManager->addRules(['/' => $indexUrl], false);
    }

    protected function add($model)
    {
        $this->items[$model->key] = $model;

        return $this;
    }

    protected function initI18n($app)
    {
        if (!isset($app->get('i18n')->translations['app*'])) {
            $app->get('i18n')->translations['app*'] = [
                'class'    => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US'
            ];
        }
    }
}
