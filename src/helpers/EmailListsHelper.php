<?php
namespace wajox\yii2base\helpers;

use wajox\yii2base\models\EmailList;
use yii\helpers\ArrayHelper;

class EmailListsHelper
{
    public static function getEmailLists()
    {
        return ArrayHelper::map(EmailList::find()->all(), 'id', 'title');
    }
}
