<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class RemoteAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/remote.js',
    ];

    public $depends = [];
}
