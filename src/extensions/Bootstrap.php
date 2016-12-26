<?php
namespace wajox\yii2base\extensions;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use yii\console\Application as ConsoleApplication;
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

        $this->setupAliases();
        $this->setupAppTheme($theme, $app);
        $this->setupAppIndexUrl($indexUrl, $app);
        $this->initI18n($app);
        $this->initControllersMap($app);
    }

    protected function setupAliases()
    {
        \Yii::setAlias('@wajox/yii2base', '@vendor/wajox/yii2base/src');
    }

    protected function setupAppTheme($theme, $app)
    {
        $themesPath = 'themes/';
        $themesUrl = '@themes/';
        $baseThemePath = '@wajox/yii2base/themes/' . self::APP_BASE_THEME;

        if ($theme === self::APP_BASE_THEME) {
            $themesPath = '@wajox/yii2base/themes/';
            $themesUrl = '@wajox/yii2base/themes/';
        }

        $app->view->theme->basePath = $themesPath . $theme;
        $app->view->theme->baseUrl = $themesUrl . $theme;

        $app->view->theme->pathMap = [
                //external
                '@app/views' => [
                        '@themes/' . $theme . '/views',
                        $baseThemePath . '/views',
                    ],
                '@app/modules' => [
                        '@themes/' . $theme . '/modules',
                        $baseThemePath . '/modules',
                    ],
                '@app/mail' => [
                        '@themes/' . $theme . '/mail',
                        $baseThemePath . '/mail',
                        '@wajox/yii2base/mail',
                    ],
                '@app/widgets' => [
                        '@themes/' . $theme . '/widgets',
                        $baseThemePath . '/widgets',
                    ],

                // internal
                '@wajox/yii2base/views' => [
                        '@themes/' . $theme . '/views',
                        $baseThemePath . '/views',
                    ],
                '@wajox/yii2base/modules' => [
                        '@themes/' . $theme . '/modules',
                        $baseThemePath . '/modules',
                    ],
                '@wajox/yii2base/mail' => [
                        '@themes/' . $theme . '/mail',
                        $baseThemePath . '/mail',
                        '@wajox/yii2base/mail',
                    ],
                '@wajox/yii2base/widgets' => [
                        '@themes/' . $theme . '/widgets',
                        $baseThemePath . '/widgets',
                    ],
            ];


        //print_r($app->view->theme->pathMap);
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

    protected function initControllersMap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $app->controllerMap = [
                'good-letter-emails' => 'wajox\yii2base\commands\GoodLetterEmailsController',
                'mailer' => 'wajox\yii2base\commands\MailerController',
                'orders' => 'wajox\yii2base\commands\OrdersController',
                'partners' => 'wajox\yii2base\commands\PartnersController',
                'rbac' => 'wajox\yii2base\commands\RbacController',
                'sender-settings' => 'wajox\yii2base\commands\SenderSettingsController',
                'settings' => 'wajox\yii2base\commands\SettingsController',
                'uploaded-files' => 'wajox\yii2base\commands\UploadedFilesController',
                'user-notifications' => 'wajox\yii2base\commands\UserNotificationsController',
                'users' => 'wajox\yii2base\commands\UsersController',
            ];

            return;
        }

        $app->controllerMap = [
            'site' => 'wajox\yii2base\controllers\SiteController',
            'confirmation' => 'wajox\yii2base\controllers\ConfirmationController',
            'content-nodes' => 'wajox\yii2base\controllers\ContentNodesController',
            'password' => 'wajox\yii2base\controllers\PasswordController',
            'subscribes' => 'wajox\yii2base\controllers\SubscribesController',
            'traffic-streams' => 'wajox\yii2base\controllers\TrafficStreamsController',
        ];
    }
}
