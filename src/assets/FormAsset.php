<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class FormAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/form.js',
    ];

    public $depends = [];
}
