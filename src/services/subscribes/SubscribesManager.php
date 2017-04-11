<?php
namespace wajox\yii2base\services\subscribes;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Subscribe;
use wajox\yii2base\models\EmailList;
use wajox\yii2base\helpers\UsersHelper;
use wajox\yii2base\events\EmailListEvent;
use wajox\yii2base\components\base\Object;

class SubscribesManager extends Object
{
    public function subscribeCustomer($email_list, $customer)
    {
        $model = $this->createObject(Subscribe::className());
        $model->email_list_id = $email_list->id;
        $model->email = $customer->email;
        $model->name = $customer->fullName;

        return $this->createModel($model);
    }

    public function subscribeOrder($order)
    {
        foreach ($order->goods as $good) {
            foreach ($good->emailLists as $emailList) {
                $this->subscribeCustomer($emailList, $order->customer);
            }
        }
    }

    public function subscribeGuest($data, $emailList)
    {
        $model = $this->createObject(Subscribe::className());
        $model->load($data);
        $model->email_list_id = $emailList->id;

        return $this->createModel($model);
    }

    public function unsubscribe($email, $emailList = null)
    {
        $query = $this
            ->getRepository()
            ->find(Subscribe::className())
            ->where(['email' => $email]);

        if ($emailList) {
            $query->andWhere(['email_list_id' => $emailList->id]);
        }

        $subscribes = $query->all();

        foreach ($subscribes as $subscribe) {
            $this->triggerEvent(
                $subscribe,
                EmailListEvent::EVENT_UNSUBSCRIBE,
                $subscribe->user
            );

            $this
                ->getApp()
                ->mailer
                ->deleteUserFromList(
                    $subscribe->email,
                    $subscribe->emailList->api_id
                );

            $subscribe->status_id = Subscribe::STATUS_ID_DELETED;
            $subscribe->save();
        }
    }

    protected function createModel($model)
    {
        $model = $this->setSubscriptionExternalData($model);

        if ($model->save()) {
            $this->triggerEvent(
                $model,
                EmailListEvent::EVENT_SUBSCRIBE,
                $model->user
            );
            
            $this->synchronizeSubscription($model);
        }

        return $model;
    }

    protected function synchronizeSubscription($model)
    {
        $data = [
            'email' => $model->email,
            'name' => $model->name,
            'list_id' => $model->emailList->api_id,
        ];

        return $this->getApp()->mailer->addUserToList($data);
    }

    protected function setSubscriptionExternalData($model)
    {
        $model->status_id = Subscribe::STATUS_ID_NEW;
        $model->guid = $this->getApp()->visitor->guid;
        $model->user_id = $this->getApp()->visitor->userId;
        $model->created_at = time();

        if ($this->getApp()->user->isGuest) {
            $model->user_id = UsersHelper::getUserIdByEmail($model->email);
        }

        return $model;
    }

    public function triggerEvent($model, $type)
    {
        $event = $this->createObject(EmailListEvent::className());
        $event->emailList = $model->emailList;
        $event->subscribe = $model;
        $this
            ->getApp()
            ->eventsManager
            ->trigger(EmailList::className(), $type, $event);
    }
}
