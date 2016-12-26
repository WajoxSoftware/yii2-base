<?php
namespace wajox\yii2base\services\message;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Message;
use wajox\yii2base\models\MessageUserStatus;
use wajox\yii2base\models\DialogUser;
use wajox\yii2base\services\events\types\MessageUserStatusEvent;
use wajox\yii2base\components\base\Object;

class MessagesManager extends Object
{
    public $message;

    public function createMessage($dialog, $user, $data)
    {
        $model = $this->createObject(Message::className());
        $model->load($data);
        $model->status_id = Message::STATUS_ID_SEND;
        $model->status_at = time();
        $model->dialog_id = $dialog->id;
        $model->user_id = $user->id;

        if (! $model->save()) {
            return false;
        }

        return $model;
    }

    public function sendMessage($message, $users)
    {
        $success = true;

        $messageStatusRows = [];

        foreach ($users as $user) {
            $messageStatusRows[] = $this->buildMessageUserStatus($message, $user)->attributes;
        }

        $this->insertMessageUserStatuses($messageStatusRows);
        $this->updateDialogUsers($message);

        return $success;
    }

    public function readMessage($user, $message)
    {
        return $this->updateMessageUserStatus($user, $message, MessageUserStatus::STATUS_ID_READ);
    }

    public function deleteMessage($user, $message)
    {
        return $this->updateMessageUserStatus($user, $message, MessageUserStatus::STATUS_ID_DELETED);
    }

    public function updateMessageUserStatus($user, $message, $statusId)
    {
        $model = MessageUserStatus::find()->where([
                'message_id' => $message->id,
                'user_id' => $user->id,
            ])->one();

        if ($model == null) {
            return false;
        }

        $model->status_id = $statusId;
        $model->status_at = time();

        if (!$model->save()) {
            return false;
        }

        $this->triggerEvent($model);

        if ($statusId !== MessageUserStatus::STATUS_ID_DELETED) {
            return true;
        }

        $userDialog = $this->findDialogUser($model);

        if ($userDialog == null) {
            return false;
        }

        $lastMessageStatus = $this->findLastMessageUserStatus($model);

        $userDialog->message_id = $lastMessageStatus == null ? 0 : $lastMessageStatus->message_id;

        return $userDialog->save();
    }

    protected function buildMessageUserStatus($message, $user)
    {
        $model = $this->createObject(MessageUserStatus::className());
        $model->dialog_id = $message->dialog_id;
        $model->message_id = $message->id;
        $model->user_id = $user->id;
        $model->status_at = time();
        $model->status_id = MessageUserStatus::STATUS_ID_NEW;

        if ($message->user_id == $user->id) {
            $model->status_id = MessageUserStatus::STATUS_ID_READ;
        }

        $model->created_at = $message->status_at;

        $this->triggerEvent($model);

        return $model;
    }

    protected function findDialogUser($model)
    {
        return DialogUser::find()
            ->where([
                'dialog_id' => $model->dialog_id,
                'user_id' => $model->user_id,
            ])->one();
    }
    protected function findLastMessageUserStatus($model)
    {
        $activeStatuses = [
            MessageUserStatus::STATUS_ID_READ,
            MessageUserStatus::STATUS_ID_NEW,
        ];

        return MessageUserStatus::find()
            ->where([
                'dialog_id' => $model->dialog_id,
                'user_id' => $model->user_id,
                'status_id' => $activeStatuses,
            ])->orderBy([
                'created_at' => 'DESC',
            ])->one();
    }

    protected function insertMessageUserStatuses($rows)
    {
        $messageStatus = $this->createObject(MessageUserStatus::className());

        $count = $this->getApp()->db->createCommand()->batchInsert(
                MessageUserStatus::tableName(),
                $messageStatus->attributes(),
                $rows
            )->execute();

        return $count;
    }

    protected function updateDialogUsers($message)
    {
        $this->getApp()->db->createCommand()->update(
                DialogUser::tableName(),
                [
                    'message_id' => $message->id,
                    'updated_at' => $message->status_at,
                ],
                ['dialog_id' => $message->dialog_id]
            )->execute();
    }

    protected function triggerEvent($model)
    {
        if ($model->status_id == MessageUserStatus::STATUS_ID_NEW) {
            $type = MessageUserStatusEvent::EVENT_CREATED;
        } elseif ($model->status_id == MessageUserStatus::STATUS_ID_READ) {
            $type = MessageUserStatusEvent::EVENT_READ;
        } elseif ($model->status_id == MessageUserStatus::STATUS_ID_DELETED) {
            $type = MessageUserStatusEvent::EVENT_DELETED;
        } else {
            return;
        }

        $event = $this->reateObject(MessageUserStatusEvent::className());
        $event->messageUserStatus = $model;
        $this->getApp()->eventsManager->trigger(MessageUserStatus::className(), $type, $event);
    }
}
