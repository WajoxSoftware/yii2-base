<?php
namespace wajox\yii2base\services\message;

use wajox\yii2base\models\User;
use wajox\yii2base\models\UserContact;
use wajox\yii2base\models\ContactRequest;
use wajox\yii2base\services\users\PrivacySettingsManager;
use wajox\yii2base\components\base\Object;

class ContactsManager extends Object
{
    protected $user;

    public function __construct(User $user)
    {
        $this->setUser($user);
    }

    public function isEmpty()
    {
        return $this->user == null;
    }

    public function hasContact($user)
    {
        return $this->getContactModels($user)->count() > 0;
    }

    public function sendRequestTo($user)
    {
        if (!$this->canSendRequestTo($user)) {
            return;
        }

        $request = $this->createObject(ContactRequest::className());
        $request->user_id = $this->user->id;
        $request->contact_user_id = $user->id;

        if (!$request->save()) {
            throw new \Exception('Can not create contact request');
        }

        return $request;
    }

    public function approveRequest($user)
    {
        foreach ($this->getRequestModels($user)->each() as $model) {
            $model->delete();
        }

        $this->saveContact($user);

        return $this;
    }

    public function cancelRequest($user)
    {
        foreach ($this->getRequestModels($user)->each() as $model) {
            $model->delete();
        }

        return $this;
    }

    public function canSendRequestTo($user)
    {
        if ($this->isEmpty()) {
            return false;
        }

        $privacyManager = $this->createObject(
            PrivacySettingsManager::className(),
            [$user]
        );

        $hasAccess = $privacyManager
            ->addTargetUsersIds([$user->id])
            ->canAdd($user->id);

        if (!$hasAccess) {
            return false;
        }

        return !$this->hasContact($user)
               && !$this->hasRequest($user);
    }

    public function removeContact($user)
    {
        foreach ($this->getContactModels($user)->each() as $model) {
            $model->delete();
        }
    }

    public function getContactsQuery()
    {
        $usersIds = [];
        foreach ($this->user->contacts as $userContact) {
            $userId = $userContact->contact_user_id;
            $usersIds[$userId] = $userId;
        }

        return $this->findUsersByIds($usersIds);
    }

    public function getRequestsQuery()
    {
        $usersIds = [];
        foreach ($this->user->requests as $request) {
            $userId = $request->user_id;
            $usersIds[$userId] = $userId;
        }

        return $this->findUsersByIds($usersIds);
    }

    public function getSentRequests()
    {
        return $this
            ->getRepository()
            ->find(ContactRequest::className())
            ->where(['user_id' => $this->user->id])
            ->indexBy('contact_user_id')
            ->all();
    }

    protected function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    protected function hasRequest($user)
    {
        return $this->getRequestModels($user)->count() > 0;
    }

    protected function saveContact($user)
    {
        if ($this->getContactModels($user)->count() > 0) {
            return;
        }

        $this->addContactModel($user->id, $this->user->id)
             ->addContactModel($this->user->id, $user->id);
    }

    protected function getContactModels($user)
    {
        return $this
            ->getRepository()
            ->find(UserContact::className())
            ->where([
                'user_id' => $this->user->id,
                'contact_user_id' => $user->id,
            ])
            ->orWhere([
                'user_id' => $user->id,
                'contact_user_id' => $this->user->id,
            ]);
    }

    protected function getRequestModels($user)
    {
        return $this
            ->getRepository()
            ->find(ContactRequest::className())
            ->where([
                'user_id' => $this->user->id,
                'contact_user_id' => $user->id,
            ])
            ->orWhere([
                'user_id' => $user->id,
                'contact_user_id' => $this->user->id,
            ]);
    }

    protected function addContactModel($userId, $contactUserId)
    {
        $model = $this->createObject(UserContact::className());
        $model->user_id = $userId;
        $model->contact_user_id = $contactUserId;
        if (!$model->save()) {
            throw new \Exception('Can not save user contact');
        }

        return $this;
    }

    protected function findUsersByIds($usersIds)
    {
        return $this
            ->getRepository()
            ->find(User::className())
            ->byIds($usersIds);
    }
}
