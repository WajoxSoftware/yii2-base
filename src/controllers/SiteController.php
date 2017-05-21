<?php
namespace wajox\yii2base\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use wajox\yii2base\models\form\ContactForm;

class SiteController extends \wajox\yii2base\controllers\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSendQuestion()
    {
        if (!$this->getApp()->request->isPost) {
            throw new \Exception();
        }

        $message = $this->getApp()->request->post('message');
        $from = $this->getApp()->request->post('email');
        $to = 'wajox@mail.ru';//$this->getApp()->params['adminEmail'];

        $subject = 'Сообщение с сайта';

        $content = 'Message: ' . $message . PHP_EOL . 'E-mail: ' . $from;

        $this
            ->getApp()
            ->mailer
            ->sendTransactional($to, $subject, $content, $content);

        return $this->render('send-question');
    }

    public function actionContact()
    {
        $this->layout = 'narrow';
        $model = $this->createObject(ContactForm::className());
        
        if ($model->load($this->getApp()->request->post()) && $model->contact($this->getApp()->params['adminEmail'])) {
            $this->getApp()->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
