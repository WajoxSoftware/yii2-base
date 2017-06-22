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

    protected $i18nMap = [
        'app/general' => 'general.php',
        'app/notifications' => 'notifications.php',
        'app/models' => 'models.php',
        'app/attributes' => 'attributes.php',
        'app/account' => 'account.php',
        'app/admin' => 'admin.php',
        'app/dialogs' => 'dialogs.php',
        'app/partner' => 'partner.php',
        'app/payment' => 'payment.php',
        'app/profile' => 'profile.php',
        'app/shop' => 'shop.php',
        'app/trafficmanager' => 'trafficmanager.php',
        'app/validation' => 'validation.php',
        'app/error' => 'error.php',
        'app/mailer' => 'mailer.php',
        'app/webinar' => 'webinar.php',
    ];

    protected $commandsMap = [
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

    protected $controllersMap = [
        'site' => 'wajox\yii2base\controllers\SiteController',
        'confirmation' => 'wajox\yii2base\controllers\ConfirmationController',
        'content-nodes' => 'wajox\yii2base\controllers\ContentNodesController',
        'password' => 'wajox\yii2base\controllers\PasswordController',
        'subscribes' => 'wajox\yii2base\controllers\SubscribesController',
        'traffic-streams' => 'wajox\yii2base\controllers\TrafficStreamsController',
        'clicks' => 'wajox\yii2base\controllers\ClicksController',
    ];

    public function bootstrap($app)
    {
        $this->initAppSettings($app);
    }

    protected function initAppSettings($app)
    {
        $theme = $app->settings->get('app_theme', 'base');
        $indexUrl = $app->settings->get('app_index_url', 'site/index');

        $this
            ->setupAliases()
            ->setupAppTheme($theme, $app)
            ->setupAppIndexUrl($indexUrl, $app)
            ->initI18n($app)
            ->initControllersMap($app);
    }

    protected function setupAliases(): Bootstrap
    {
        \Yii::setAlias(
            '@wajox/yii2base',
            '@vendor/wajox/yii2base/src'
        );

        return $this;
    }

    protected function setupAppTheme($theme, $app): Bootstrap
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
            '@vendor' => [
                '@themes/' . $theme . '/vendor',
                $baseThemePath . '/vendor',
            ],
        ];

        return $this;
    }

    protected function setupAppIndexUrl($indexUrl, $app): Bootstrap
    {
        $app->urlManager->addRules(['/' => $indexUrl], false);

        return $this;
    }

    protected function initI18n($app): Bootstrap
    {
        if (isset($app->i18n->translations['app*'])) {
            return $this;
        }

        $app->i18n->translations['app*'] = [
            'class'    => PhpMessageSource::className(),
            'basePath' => __DIR__ . '/../messages',
            'fileMap' => $this->i18nMap,
        ];

        return $this;
    }

    protected function initControllersMap($app): Bootstrap
    {
        if ($app instanceof ConsoleApplication) {
            $app->controllerMap = $this->commandsMap;

            return $this;
        }

        $app->controllerMap = $this->controllersMap;

        return $this;
    }
}
