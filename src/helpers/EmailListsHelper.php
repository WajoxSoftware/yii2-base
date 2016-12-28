<?php
namespace wajox\yii2base\helpers;

use yii\helpers\ArrayHelper;

class EmailListsHelper
{
    public static function getEmailLists()
    {
        return ArrayHelper::map(EmailList::find()->all(), 'id', 'title');
    }
}
