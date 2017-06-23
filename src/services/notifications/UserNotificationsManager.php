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

    public function createSystemMessage(string $subject, string $message): bool
    {
        return $this->create(
            $subject,
            $message,
            UserNotification::TYPE_ID_SYSTEM
        );
    }

    public function createAccountMessage(string $subject, string $message): bool
    {
        return $this->create(
            $subject,
            $message,
            UserNotification::TYPE_ID_ACCOUNT
        );
    }

    public function createOrderMessage(string $subject, string $message, int $orderId): bool
    {
        return $this->create(
            $subject,
            $message,
            UserNotification::TYPE_ID_SYSTEM,
            ['orderId' => $orderId]
        );
    }

    public function readAll()
    {
        $this
            ->getRepository()
            ->update(
                UserNotification::className(),
                ['status_id' => UserNotification::STATUS_ID_READ],
                [
                    'user_id' => $this->user->id,
                    'status_id' => UserNotification::STATUS_ID_NEW,
                ]
            );
    }

    public function read(int $id)
    {
        $this
            ->getRepository()
            ->update(
                UserNotification::className(),
                ['status_id' => UserNotification::STATUS_ID_READ],
                [
                    'user_id' => $this->user->id,
                    'status_id' => UserNotification::STATUS_ID_NEW,
                    'id' => $id,
                ]
            );
    }

    public function orderStatusNotification($order): bool
    {
        $newStatus = $order->status . '/' . $order->deliveryStatus;

        $content = \Yii::t(
            'app/notifications',
            'Order Status Changed to {newStatus}',
            [
                'newStatus' => $newStatus,
                'orderId' => $order->id,
            ]
        );

        $subject = \Yii::t(
            'app/notifications',
            'Order Status Change Subject'
        );

        return $this->createOrderMessage(
            $subject,
            $content,
            $order->id
        );
    }

    public function messageStatusNotification($messageUserStatus): bool
    {
        $message = $messageUserStatus->message;

        $content = \Yii::t(
            'app/notifications',
            'New Nessage {messageText} from {name}',
            [
                'messageText' => $message->content,
                'name' => $message->user->fullName,
            ]
        );

        $subject = \Yii::t(
            'app/notifications',
            'New Message Subject'
        );

        return $this->createAccountMessage($subject, $content);
    }

    protected function create(
        string $subject,
        string $message,
        int $typeId,
        array $params = []
    ): bool
    {
        $model = $this->buildModel($typeId);

        $model
            ->setSubject($subject)
            ->setMessage($message)
            ->setContentParams($params);
    
        return $model->save();
    }

    protected function buildModel(int $typeId): UserNotification
    {
        $model = $this->createObject(UserNotification::className());
        $model->status_id = UserNotification::STATUS_ID_NEW;
        $model->type_id = $typeId;
        $model->user_id = $this->user->id;
        $model->created_at = time();

        return $model;
    }
}
