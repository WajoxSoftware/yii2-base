<?php

namespace wajox\yii2base\themes\base\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@themes/base/assets-src';

    public $css = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
        'libs/font-awesome/css/font-awesome.min.css',
        'http://fonts.googleapis.com/css?family=Open+Sans',
        'css/stacktable.css',
        'css/site.css',
        'css/app.css',
        'css/custom_app.css',
        'libs/flatui/css/flat-ui.css',
    ];
    public $js = [
        'https://files-stackablejs.netdna-ssl.com/stacktable.min.js',
        'libs/flatui/js/flat-ui.js',
    ];
    public $depends = [
        'wajox\yii2base\assets\AppAsset',
    ];
}
