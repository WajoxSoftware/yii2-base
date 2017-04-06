<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/app.js',
        'js/statistic.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
