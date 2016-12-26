<?php
namespace wajox\yii2base\services\users;

use wajox\yii2base\models\UserSettings;
use wajox\yii2base\components\base\Object;

class PrivacySettingsManager extends Object
{
    protected $user;
    protected $targetUsersIds = [];
    protected $targetUsersSettings = [];
    protected $accessTable = [];

    const PROFILE_VIEW     = 'view_profile';
    const PROFILE_SEARCH   = 'search_profile';
    const PROFILE_ADD      = 'add_profile';
    const PROFILE_MESSAGE  = 'message_profile';
    const PROFILE_CONTACTS = 'show_contacts';

    const ACCESS_NOBODY = 100;
    const ACCESS_ALL = 200;
    const ACCESS_USERS = 300;
    const ACCESS_CONTACTS = 400;

    public function __construct($user, $targetUsersIds = [])
    {
        $this->setUser($user)
             ->addTargetUsersIds($targetUsersIds);
    }

    public function getPermissionsList()
    {
        return [
            self::PROFILE_VIEW,
            self::PROFILE_SEARCH,
            self::PROFILE_ADD,
            self::PROFILE_MESSAGE,
            self::PROFILE_CONTACTS,
        ];
    }

    public static function getAccessList()
    {
        return [
            self::ACCESS_NOBODY => \Yii::t('app/attributes', 'User Access List Nobody'),
            self::ACCESS_ALL => \Yii::t('app/attributes', 'User Access List All'),
            self::ACCESS_USERS => \Yii::t('app/attributes', 'User Access List Users'),
            self::ACCESS_CONTACTS => \Yii::t('app/attributes', 'User Access List Contacts'),
        ];
    }

    public static function getAccessListAdd()
    {
        return [
            self::ACCESS_NOBODY => \Yii::t('app/attributes', 'User Access List Nobody'),
            self::ACCESS_USERS => \Yii::t('app/attributes', 'User Access List Users'),
        ];
    }

    public static function getAccessListMessage()
    {
        return [
            self::ACCESS_NOBODY => \Yii::t('app/attributes', 'User Access List Nobody'),
            self::ACCESS_USERS => \Yii::t('app/attributes', 'User Access List Users'),
        ];
    }

    public static function getAccessListSearch()
    {
        return [
            self::ACCESS_NOBODY => \Yii::t('app/attributes', 'User Access List Nobody'),
            self::ACCESS_ALL => \Yii::t('app/attributes', 'User Access List All'),
        ];
    }

    public function addTargetUsersIds($targetUsersIds)
    {
        $targetUsersIds = array_merge($this->targetUsersIds, $targetUsersIds);
        $this->targetUsersIds = array_unique($targetUsersIds);
        $this->loadSettings($targetUsersIds);

        return $this;
    }

    public function canView($targetUserId)
    {
        return $this->getAccessTableValue($targetUserId, self::PROFILE_VIEW);
    }

    public function canViewContacts($targetUserId)
    {
        return $this->getAccessTableValue($targetUserId, self::PROFILE_CONTACTS);
    }

    public function canSearch($targetUserId)
    {
        return $this->getAccessTableValue($targetUserId, self::PROFILE_SEARCH);
    }

    public function canWriteMessage($targetUserId)
    {
        return $this->getAccessTableValue($targetUserId, self::PROFILE_MESSAGE);
    }

    public function canAdd($targetUserId)
    {
        return $this->getAccessTableValue($targetUserId, self::PROFILE_ADD);
    }

    protected function isGuest()
    {
        return $this->getUser() == null;
    }

    protected function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    protected function getUser()
    {
        return $this->user;
    }

    protected function loadSettings($usersIds)
    {
        $existsIds = array_keys($this->targetUsersSettings);
        $usersIds = array_diff($usersIds, $existsIds);

        $usersSettingsQuery = UserSettings::find()->where(['id' => $usersIds]);

        foreach ($usersSettingsQuery->each() as $model) {
            $this->targetUsersSettings[$model->id] = $model;
            $this->computeAccessValues($model->id);
        }
    }

    protected function getTargetUsersIds()
    {
        return $this->targetUsersIds;
    }

    protected function getAccessTableValue($targetUserId, $access)
    {
        if ($this->isSelf($targetUserId)) {
            return true;
        }

        if ($this->isAdmin()) {
            return true;
        }

        return isset($this->accessTable[$targetUserId][$access]) && $this->accessTable[$targetUserId][$access];
    }

    protected function setAccessTableValue($targetUserId, $access, $value)
    {
        $this->accessTable[$targetUserId][$access] = $value;

        return $this;
    }

    protected function getUserSettings($targetUserId)
    {
        if (isset($this->targetUsersSettings[$targetUserId])) {
            return $this->targetUsersSettings[$targetUserId];
        }

        return;
    }

    protected function computeAccessValues($targetUserId)
    {
        if ($this->isSelf($targetUserId)) {
            return;
        }

        if (($userSettings = $this->getUserSettings($targetUserId)) == null) {
            return;
        }

        foreach ($this->getPermissionsList() as $permission) {
            $value = $userSettings->$permission;
            $access = $this->computeAccessValue($targetUserId, $value);
            $this->setAccessTableValue($targetUserId, $permission, $access);
        }
    }

    protected function computeAccessValue($targetUserId, $value)
    {
        if ($value == null
            || $value == self::ACCESS_NOBODY
        ) {
            return false;
        }

        if ($value == self::ACCESS_ALL) {
            return true;
        }

        if ($value == self::ACCESS_USERS) {
            return !$this->isGuest();
        }

        if ($value == self::ACCESS_CONTACTS
            && !$this->isGuest()
        ) {
            return $this->isContact($targetUserId);
        }

        return false;
    }

    protected function isAdmin()
    {
        if ($this->isGuest()) {
            return false;
        }

        return $this->getUser()->isAdmin;
    }

    protected function isSelf($targetUserId)
    {
        if ($this->isGuest()) {
            return false;
        }

        return $this->getUser()->id == $targetUserId;
    }

    protected function isContact($targetUserId)
    {
        if ($this->isGuest()) {
            return false;
        }

        $count = $this->getUser()->getContacts()->andWhere([
                'contact_user_id' => $targetUserId,
            ])->count();

        return $count > 0;
    }
}
