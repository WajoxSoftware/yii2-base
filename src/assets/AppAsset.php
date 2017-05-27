<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
        'wajox\yii2base\assets\AppJSAsset',
        'wajox\yii2base\assets\StatisticAsset',
        'wajox\yii2base\assets\RemoteAsset',
        'wajox\yii2base\assets\FormAsset',
        'wajox\yii2base\assets\WidgetsAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
