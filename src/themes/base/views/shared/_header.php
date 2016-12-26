<?php
use yii\bootstrap\NavBar;
use yii\helpers\Url;

    NavBar::begin([
        'brandLabel' => \Yii::t('app', 'App Name'),
        'brandUrl' => Url::home(),
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);

    NavBar::end();
