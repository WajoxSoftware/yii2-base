<?php
namespace wajox\yii2base\assets;

use yii\web\AssetBundle;

class StatisticAsset extends AssetBundle
{
    public $sourcePath = '@wajox/yii2base/assets-src';

    public $css = [];

    public $js = [
        'js/statistic.js',
    ];

    public $depends = [];
}
