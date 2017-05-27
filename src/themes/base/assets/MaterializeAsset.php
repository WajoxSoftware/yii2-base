<?php
namespace wajox\yii2base\themes\base\assets;

use yii\web\AssetBundle;

class MaterializeAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/themes/base/assets-src';

    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'css/materialize.css',
    ];

    public $js = [
        'js/materialize.js',
        'js/materialize-widgets.js',
    ];

    public $depends = [];
}
