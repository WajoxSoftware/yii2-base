<?php
namespace wajox\yii2base\services\notifications;

use wajox\yii2base\models\UserNotification;
use wajox\yii2base\components\base\Object;

class UserNotificationsManager extends Object
{
    protected $user = null;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function createSystemMessage($subject, $message)
    {
        return $this->create($subject, $message, UserNotification::TYPE_ID_SYSTEM);
    }

    public function createAccountMessage($subject, $message)
    {
        return $this->create($subject, $message, UserNotification::TYPE_ID_ACCOUNT);
    }

    public function createOrderMessage($subject, $message, $orderId)
    {
        return $this->create($subject, $message, UserNotification::TYPE_ID_SYSTEM, ['orderId' => $orderId]);
    }

    public function readAll()
    {
        $this->getApp()->db->createCommand()->update(
                UserNotification::tableName(),
                ['status_id' => UserNotification::STATUS_ID_READ],
                [
                    'user_id' => $this->user->id,
                    'status_id' => UserNotification::STATUS_ID_NEW,
                ]
            )->execute();
    }

    public function read($id)
    {
        $this->getApp()->db->createCommand()->update(
                UserNotification::tableName(),
                ['status_id' => UserNotification::STATUS_ID_READ],
                [
                    'user_id' => $this->user->id,
                    'status_id' => UserNotification::STATUS_ID_NEW,
                    'id' => $id,
                ]
            )->execute();
    }

    public function orderStatusNotification($order)
    {
        $newStatus = $order->status . '/' . $order->deliveryStatus;

        $content = \Yii::t('app/notifications', 'Order Status Changed to {newStatus}', [
                'newStatus' => $newStatus,
                'orderId' => $order->id,
            ]);

        $subject = \Yii::t('app/notifications', 'Order Status Change Subject');

        return $this->createOrderMessage($subject, $content, $order->id);
    }

    public function messageStatusNotification($messageUserStatus)
    {
        $message = $messageUserStatus->message;

        $content = \Yii::t('app/notifications', 'New Nessage {messageText} from {name}', [
                'messageText' => $message->content,
                'name' => $message->user->fullName,
            ]);

        $subject = \Yii::t('app/notifications', 'New Message Subject');

        return $this->createAccountMessage($subject, $content);
    }

    protected function create($subject, $message, $typeId, $params = [])
    {
        $model = $this->buildModel($typeId);

        $model->setSubject($subject)->setMessage($message)->setContentParams($params);

        return $model->save();
    }

    protected function buildModel($typeId)
    {
        $model = $this->createObject(UserNotification::className());
        $model->status_id = UserNotification::STATUS_ID_NEW;
        $model->type_id = $typeId;
        $model->user_id = $this->user->id;
        $model->created_at = time();

        return $model;
    }
}
