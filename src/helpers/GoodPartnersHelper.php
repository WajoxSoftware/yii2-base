<?php
namespace wajox\yii2base\helpers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Partner;

class GoodPartnersHelper
{
    public static function getPartnersList()
    {
        $result = ['0' => \Yii::t('app/attributes', 'All')];

        foreach (Partner::find()->all() as $partner) {
            $result[$partner->id] = $partner->user->nameWithEmail;
        }

        return $result;
    }
}
