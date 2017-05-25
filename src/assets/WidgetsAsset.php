<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class WidgetsAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/widgets.js',
    ];

    public $depends = [];
}
