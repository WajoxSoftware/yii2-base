<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class MaterializeAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/materialize.js',
    ];

    public $depends = [];
}
