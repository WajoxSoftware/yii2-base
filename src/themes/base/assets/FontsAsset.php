<?php
namespace wajox\yii2base\themes\base\assets;

use yii\web\AssetBundle;

class FontsAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/themes/base/assets-src';

    public $css = [
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
        'libs/font-awesome/css/font-awesome.min.css',
        'css/stacktable.css',
        'css/fonts.css',
    ];

    public $js = [];

    public $depends = [];
}
