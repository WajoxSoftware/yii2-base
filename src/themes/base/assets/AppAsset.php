<?php
namespace wajox\yii2base\themes\base\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/themes/base/assets-src';

    public $css = [
        'css/stacktable.css',
    ];

    public $js = [];

    public $depends = [
        'wajox\yii2base\assets\AppAsset',
        'wajox\yii2base\themes\base\assets\FontsAsset',
        'wajox\yii2base\themes\base\assets\MaterializeAsset',
    ];
}
