<?php
namespace wajox\yii2base\themes\base\assets;

use yii\web\AssetBundle;

class ProfileAsset extends AssetBundle
{
    public $sourcePath = '@themes/base/assets-src';

    public $css = [
        'css/messages.css',
        'css/bills.css',
        'css/profile.css',
        'css/users.css',
    ];

    public $js = [
        'js/sidebar.js',
    ];

    public $depends = [
        'wajox\yii2base\themes\base\assets\AppAsset',
    ];
}
