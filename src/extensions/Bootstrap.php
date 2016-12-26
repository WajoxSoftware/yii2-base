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

        $this->setupAppTheme($theme, $app);
        $this->setupAppIndexUrl($indexUrl, $app);
        $this->initI18n($app);
        $this->initControllersMap($app);
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

    protected function initControllersMap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $app->controllerMap => [
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

        $app->controllerMap => [
            'site' => 'wajox\yii2base\controllers\SiteController',
            'confirmation' => 'wajox\yii2base\controllers\ConfirmationController',
            'content-nodes' => 'wajox\yii2base\controllers\ContentNodesController',
            'password' => 'wajox\yii2base\controllers\PasswordController',
            'subscribes' => 'wajox\yii2base\controllers\SubscribesController',
            'traffic-streams' => 'wajox\yii2base\controllers\TrafficStreamsController',
        ];
    }
}
