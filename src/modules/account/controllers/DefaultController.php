<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\MessageUserStatus;

class DefaultController extends ApplicationController
{
    public function actionIndex()
    {
        $user = $this->getUser();

        $stat = [];

        $stat['unread_messages'] = $this
            ->getRepository()
            ->find(MessageUserStatus::className())
            ->where(['user_id' => $user->id, 'status_id' => MessageUserStatus::STATUS_ID_NEW])
            ->count();

        $stat['account_balance'] = $user->accountBalanceRUR;

        return $this->render('index', [
            'stat' => $stat,
        ]);
    }
}
