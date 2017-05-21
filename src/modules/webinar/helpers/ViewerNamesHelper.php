<?php
namespace wajox\yii2base\modules\webinar\helpers;

class ViewerNamesHelper
{
    public static function generateNames(int $namesCount = 10)
    {
        return array_fill(0, $namesCount, 'Vasya Pupkin');
    }
}
