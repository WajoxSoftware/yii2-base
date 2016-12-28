<?php
namespace wajox\yii2base\services\message;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Dialog;
use wajox\yii2base\models\Message;
use wajox\yii2base\models\MessageUserStatus;
use wajox\yii2base\models\DialogUser;
use wajox\yii2base\models\DialogMembers;
use wajox\yii2base\components\base\Object;

class DialogsManager extends Object
{
    public $user = null;
    public $dialog = null;
    public $lastMessageStatus = null;

    public function __construct($user, $dialog = null)
    {
        $this->user = $user;
        $this->dialog = $dialog;
        $this->lastMessageStatus = $this->getLastMessageStatus();
    }

    public function getAllUserDialogsQuery()
    {
        $query = $this
            ->getRepository()
            ->find(DialogUser::className())
            ->where(['user_id' => $this->user->id])
            ->andWhere(['status_id' => DialogUser::STATUS_ID_ACTIVE])
            ->andWhere(['!=', 'message_id', 0])
            ->orderBy(['updated_at' => 'DESC']);

        return $query;
    }

    public function getDialogsUsersByDialogsIds($dialogsIds)
    {
        $query = $this
            ->getRepository()
            ->find(DialogUser::className())
            ->where(['!=', 'user_id', $this->user->id])
            ->andWhere(['dialog_id' => $dialogsIds]);

        return $query->all();
    }

    public function getMembersByDialogsIds($dialogsIds)
    {
        $dialogUsers = $this->getDialogsUsersByDialogsIds($dialogsIds);

        $usersDialogs = [];
        $usersIds = [];

        foreach ($dialogUsers as $dialogUser) {
            $usersIds[] = $dialogUser->user_id;
            $usersDialogs[$dialogUser->user_id] = $dialogUser->dialog_id;
        }

        $members = $this->getMembersMapByIds($usersIds, function ($users) use ($usersDialogs) {
            $result = [];
            foreach ($users as $user) {
                $dialogId = $usersDialogs[$user->id];
                $userId = $user->id;
                $result[$dialogId][$userId] = $user;
            }

            return $result;
        });

        return $members;
    }

    public function getDialogsDataByIds($dialogsIds)
    {
        $dialogUsers = $this->getDialogsUsersByDialogsIds($dialogsIds);

        $usersDialogs = [];
        $usersIds = [];
        $messagesIds = [];

        foreach ($dialogUsers as $dialogUser) {
            $usersIds[] = $dialogUser->user_id;
            $messagesIds[] = $dialogUser->message_id;
            $usersDialogs[$dialogUser->user_id] = $dialogUser->dialog_id;
        }

        $members = $this->getMembersMapByIds($usersIds, function ($users) use ($usersDialogs) {
            $result = [];
            foreach ($users as $user) {
                $dialogId = $usersDialogs[$user->id];
                $userId = $user->id;
                $result[$dialogId][$userId] = $user;
            }

            return $result;
        });

        $messages = $this->getMessagesMapByIds(
            $messagesIds,
            function ($messages) {
                $result = [];
                foreach ($messages as $message) {
                    $dialogId = $message->dialog_id;
                    $result[$dialogId] = $message;
                }

                return $result;
            }
        );

        return [
            'members' => $members,
            'messages' => $messages,
        ];
    }

    public function getMessagesByIds($ids)
    {
        return $this
            ->getRepository()
            ->find(Message::className())
            ->byId($ids)
            ->orderBy(['status_at' => 'DESC'])
            ->all();
    }

    public function getMembersByIds($ids)
    {
        return $this
            ->getRepository()
            ->find(User::className())
            ->byId($ids)
            ->all();
    }

    public function getMembersMapByIds($usersIds, $callback)
    {
        $members = $this->getMembersByIds($usersIds);

        return $callback($members);
    }

    public function getMessagesMapByIds($messagesIds, $callback)
    {
        $messages = $this->getMessagesByIds($messagesIds);

        return $callback($messages);
    }

    public function getDialogActiveMessageStatusesQuery()
    {
        $activeStatuses = [
            MessageUserStatus::STATUS_ID_READ,
            MessageUserStatus::STATUS_ID_NEW,
        ];

        return $this
            ->getRepository()
            ->find(MessageUserStatus::className())
            ->where(['user_id' => $this->user->id])
            ->andWhere(['dialog_id' => $this->dialog->id])
            ->andWhere(['status_id' => $activeStatuses])
            ->orderBy(['created_at' => 'DESC']);
    }

    public function getDialogMessagesQuery()
    {
        return $this
            ->getRepository()
            ->find(Message::className())
            ->orderBy(['status_at' => 'DESC']);
    }

    public function create($members)
    {
        $members[] = $this->user;
        $members = $this->uniqMembers($members);

        if (sizeof($members) == 0) {
            return false;
        }

        if ($this->loadDialogByMembers($members)) {
            $this->activateMembers(array_keys($members));

            return true;
        }

        if ($this->createDialogByMembers($members)) {
            return true;
        }

        return true;
    }

    public function loadDialog($dialog)
    {
        $this->dialog = $dialog;

        return $this;
    }

    public function addMember($user)
    {
        return $this->addMembers([$user]);
    }

    public function addMembers($users)
    {
        $this->lastMessageStatus = $this->getLastMessageStatus();

        $dialogUserRows = [];

        foreach ($users as $user) {
            $dialogUserRows[] = $this
                ->buildMember($user)
                ->attributes;
        }

        $this->getRepository()->insert(
            DialogUser::className(),
            $dialogUserRows
        );

        return true;
    }

    public function leaveDialog()
    {
        if (!$this->dialog) {
            return false;
        }

        $dialogUser = $this
            ->getRepository()
            ->find(DialogUser::className())
            ->where(['user_id' => $this->user->id])
            ->andWhere(['dialog_id' => $this->dialog->id])
            ->one();

        if (!$dialogUser) {
            return false;
        }

        $dialogUser->status_id = DialogUser::STATUS_ID_INACTIVE;
        $dialogUser->save();
        $this->clearDialog();

        return true;
    }

    public function clearDialog()
    {
        if (!$this->dialog) {
            false;
        }

        $set = [
            'status_id' => MessageUserStatus::STATUS_ID_DELETED,
        ];

        $where = [
            'user_id' => $this->user->id,
            'dialog_id' => $this->dialog->id,
        ];

        $this
            ->getRepository()
            ->update(
                MessageUserStatus::className(),
                $set,
                $where
            )
            ->execute();

        return true;
    }

    public function isMember($user)
    {
        foreach ($this->dialog->users as $model) {
            if ($user->id == $model->id) {
                return true;
            }
        }

        return false;
    }

    public function sendMessage($messageData)
    {
        if (!$this->dialog) {
            return false;
        }

        $message = $this->getMessagesManager()->createMessage(
                $this->dialog,
                $this->user,
                $messageData
            );

        if (! $message) {
            return;
        }

        if (! $this->getMessagesManager()->sendMessage($message, $this->dialog->users)) {
            return;
        }

        return $message;
    }

    public function getLastMessageStatus()
    {
        if (!$this->user) {
            return;
        }

        if (!$this->dialog) {
            return;
        }

        $activeStatuses = [
            MessageUserStatus::STATUS_ID_READ,
            MessageUserStatus::STATUS_ID_NEW,
        ];

        $lastMessageStatus = $this
            ->getRepository()
            ->find(MessageUserStatus::className())
            ->where([
                'dialog_id' => $this->dialog->id,
                'user_id' => $this->user->id,
                'status_id' => $activeStatuses,
            ])->orderBy([
                'created_at' => 'DESC',
            ])->one();

        return $lastMessageStatus;
    }

    protected function buildMember($user)
    {
        $time = time();
        $messageId = 0;

        $model = $this->createObject(DialogUser::className());
        $model->user_id = $user->id;
        $model->dialog_id = $this->dialog->id;
        $model->created_at = $time;

        if ($this->lastMessageStatus !== null) {
            $time = $this->lastMessageStatus->status_at();
            $messageId = $this->lastMessageStatus->message_id;
        }

        $model->updated_at = $time;
        $model->message_id =  $messageId;
        $model->status_id = DialogUser::STATUS_ID_ACTIVE;

        return $model;
    }

    protected function createDialogByMembers($members)
    {
        $model = $this->createObject(Dialog::className());
        $model->user_id = $this->user->id;
        $model->created_at = time();

        if (! $model->save()) {
            $this->dialog = null;

            return false;
        }

        $this->dialog = $model;

        $this->saveDialogMembers($members);

        return true;
    }

    protected function loadDialogByMembers($members)
    {
        if (sizeof($members) > 2) {
            return false;
        }

        $key = $this->getMembersUsersIdsKey($members);

        $dialogMembers = $this
            ->getRepository()
            ->find(DialogMembers::className())
            ->where(['users_ids' => $key])
            ->one();

        if (!$dialogMembers) {
            return false;
        }

        $model = $this
            ->getRepository()
            ->find(Dialog::className())
            ->byId($dialogMembers->id)
            ->one();

        if (!$model) {
            return false;
        }

        $this->dialog = $model;

        $this->activateMembers([$this->user->id]);

        return true;
    }

    public function activateMembers($ids)
    {
        $this
            ->getRepository()
            ->update(
                DialogUser::className(),
                ['status_id' => DialogUser::STATUS_ID_ACTIVE],
                ['user_id' => $ids]
            );
    }

    protected function saveDialogMembers($members)
    {
        $this->addMembers($members);

        if (sizeof($members) == 2) {
            $key = $this->getMembersUsersIdsKey($members);
            $model = $this->createOjbect(DialogMembers::className());
            $model->id = $this->dialog->id;
            $model->users_ids = $key;
            $model->save();
        }
    }

    protected function getMembersUsersIdsKey($members)
    {
        $usersIds = array_map(function ($user) {
            return $user->id;
        }, $members);

        asort($usersIds);

        $usersIds = implode('.', $usersIds);

        return $usersIds;
    }

    protected function uniqMembers($members)
    {
        $result = [];

        foreach ($members as $member) {
            $result[$member->id] = $member;
        }

        return $result;
    }

    protected function getMessagesManager()
    {
        return $this->getDepdendency(MessagesManager::className());
    }
}
