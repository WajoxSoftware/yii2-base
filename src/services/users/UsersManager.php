<?php
namespace wajox\yii2base\services\users;

use wajox\yii2base\models\User;
use wajox\yii2base\services\events\types\UserEvent;
use wajox\yii2base\components\base\Object;

class UsersManager extends Object
{
    public function getCurrentUser()
    {
        return $this->getApp()->user->identity;
    }

    public function existsEmail($email)
    {
        return User::find()->byEmail($email)->exists();
    }

    public function findByEmail($email)
    {
        return User::find()->byEmail($email)->one();
    }

    public function findByGuid($guid)
    {
        return User::find()
            ->where(['guid' => $guid])
            ->one();
    }

    public function findByEmailOrGuid($email, $guid)
    {
        return User::find()
            ->byEmailOrGuid($email, $guid)
            ->one();
    }

    public function findUnConfirmedByToken($token)
    {
        return User::find()
            ->confirmedByToken($token)
            ->one();
    }

    public function findOrCreate($email, $name)
    {
        $model = $this->findByEmail($email);

        if ($model != null) {
            return $model;
        }

        $model = $this->create($email, $name);

        if ($model != null) {
            return $model;
        }

        throw new \Exception();
    }

    public function create($email, $name, $password = null, $role = 'user')
    {
        $model = $this->buildModel($email, $name, $password, $role);

        return $this->save($model, false);
    }

    public function save($model, $addExtra = true, $sendSignupConfirmation = true)
    {
        if ($addExtra) {
            $model = $this->buildModelExtraData($model);
        }

        $isNewRecord = $model->isNewRecord;

        if ($model->password) {
            $model->setPassword($model->password);
        }

        $saved = $model->save();
        $sendSignupConfirmation = $isNewRecord && $saved && $sendSignupConfirmation;

        if ($sendSignupConfirmation) {
            $this->sendSignUpConfirmationEmail($model, $model->password);
        }

        $this->saveRole($model);

        return $model;
    }

    public function saveRole($userModel)
    {
        if ($userModel->isNewRecord) {
            return;
        }

        $auth = $this->getApp()->authManager;
        $role = $auth->getRole($userModel->role);
        $auth->assign($role, $userModel->id);
    }

    public function buildModel($email, $name, $password = null, $role = 'user')
    {
        $model = $this->createObject(
            User::className(),
            [['scenario' => 'signup']]
        );

        $model->first_name = "Jhon";
        $model->last_name = "Doe";
        $model->name = $name;
        $model->email = $email;
        $model->role = $role;
        $model->setPassword($password);

        $model = $this->buildModelExtraData($model);

        return $model;
    }

    public function buildModelExtraData($model)
    {
        if ($model->password == null) {
            $model->generatePassword();
        }

        $model->generateAuthKey();
        $model->generateConfirmationToken();

        $model->ip_address = \Yii::$app->visitor->ip;

        $modelGuid = $this->findByGuid(\Yii::$app->visitor->guid);

        if ($modelGuid
            && ($model->isNewRecord
                || $modelGuid->id != $model->id
            )
        ) {
            \Yii::$app->visitor->resetGuid();
        }

        $model->guid = \Yii::$app->visitor->guid;
        $model->referal_user_id = \Yii::$app->visitor->referalId;
        $model->created_at = time();

        return $model;
    }

    public function confirmEmail($model)
    {
        $model->confirmed_email = $model->email;
        $model->confirmation_token = md5(time().$model->email);
        $model->confirmed_at = time();

        return $model->save();
    }

    public function sendSignUpConfirmationEmail($model, $password)
    {
        $this->getMailer($model)->registration($password);

        return true;
    }

    public function sendConfirmationEmail($model)
    {
        $model->generateConfirmationToken();

        if (!$model->save()) {
            return false;
        }

        $this->getMailer($model)->confirmation();

        return true;
    }

    public function sendResetPasswordEmail($model)
    {
        $model->generatePassword();

        if (!$model->save()) {
            return false;
        }
        $this->getMailer($model)->reset_password($model->password);

        return true;
    }

    public function signIn($user, $lifetime = null)
    {
        $signedIn = $this->getApp()->user->login($user, $lifetime);

        if ($signedIn) {
            $this->triggerEvent($user, UserEvent::EVENT_SIGN_IN);
        }

        return $signedIn;
    }

    public function signOut()
    {
        $this->triggerEvent($this->getApp()->user->identity, UserEvent::EVENT_SIGN_OUT);

        return $this->getApp()->user->logout();
    }

    public function signedUp($user)
    {
        $this->triggerEvent($user, UserEvent::EVENT_SIGN_UP);
    }

    public function triggerEvent($model, $type)
    {
        $event = $this->createObject(UserEvent::className());
        $event->user = $model;
        $this->getApp()->eventsManager->trigger(User::className(), $type, $event);
    }

    protected function getMailer($model)
    {
        return $this->createObject(UserMailer::className(), [$model]);
    }
}
