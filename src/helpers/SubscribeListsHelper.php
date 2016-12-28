<?php
namespace wajox\yii2base\helpers;

use yii\helpers\ArrayHelper;

class SubscribeListsHelper
{
    public static function getListsList()
    {
        $lists = \Yii::$app->mailer->getLists();

        return ArrayHelper::map($lists, 'Id', 'Name');
    }
}
