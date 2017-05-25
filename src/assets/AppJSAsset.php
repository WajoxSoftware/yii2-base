<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class AppJSAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/app.js',
    ];

    public $depends = [];
}
