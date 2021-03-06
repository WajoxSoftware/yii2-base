<?php
namespace wajox\yii2base\modules\shop\services;

use wajox\yii2base\modules\shop\models\UserPaidGood;
use wajox\yii2base\components\base\Object;

class PurchasesManager extends Object
{
    protected $user = null;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function addOrder($order)
    {
        foreach ($order->goods as $good) {
            $this->addGood($good);
        }
    }

    public function dropOrder($order)
    {
        foreach ($order->goods as $good) {
            $this->dropGood($good);
        }
    }

    public function addGood($good)
    {
        $model = $this->createObject(UserPaidGood::className());
        $model->good_id = $good->id;
        $model->user_id = $this->user->id;
        $model->good_type_id = $good->good_type_id;
        $model->created_at = time();

        $model->save();
    }

    public function dropGood($good)
    {
        $models = $this
            ->getRepository()
            ->find(UserPaidGood::className())
            ->where([
                'user_id' => $this->user->id,
                'good_id' => $good->id,
            ]);

        foreach ($models->each() as $model) {
            $model->delete();
        }
    }
}
