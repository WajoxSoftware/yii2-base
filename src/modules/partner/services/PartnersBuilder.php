<?php
namespace wajox\yii2base\modules\partner\services;

use wajox\yii2base\models\User;
use wajox\yii2base\modules\partner\models\Partner;
use wajox\yii2base\components\base\Object;

class PartnersBuilder extends Object
{
    protected $user = null;
    protected $model = null;
    protected $request;

    public function __construct($user = null, $model = null)
    {
        $this->setUser($user)->setModel($model);
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function save($request)
    {
        try {
            $this->loadRequest($request)
                 ->build()
                 ->validate()
                 ->saveUser()
                 ->saveModel();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function loadRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function build()
    {
        return $this->buildUser()->buildModel();
    }

    protected function buildUser()
    {
        if ($this->getUser() == null) {
            $this->setUser($this->createObject(User::className()));
        }

        if ($this->getRequest()) {
            $this->user->load($this->getRequest()->post());
        }

        $this->user->role = User::ROLE_PARTNER;
        $this->user->guid = md5(uniqid(time(), true));

        if ($this->getUser()->isNewRecord) {
            $this->user->created_at = time();
        }

        return $this;
    }

    protected function buildModel()
    {
        if ($this->getModel() == null) {
            $this->setModel($this->createObject(Partner::className()));
        }

        if ($this->getRequest()) {
            $this->model->load($this->getRequest()->post());
        }

        $this->model->user_id = $this->getUser()->id;
        $this->model->type_id = Partner::TYPE_ID_CASUAL;

        if ($this->getUser()->isNewRecord) {
            $this->model->user_id = 0;
        }

        if ($this->getModel()->isNewRecord) {
            $this->model->created_at = time();
        }

        return $this;
    }

    protected function validate()
    {
        if (!$this->getUser()->validate()) {
            throw new \Exception('Invalid user data');
        }

        if (!$this->getModel()->validate()) {
            throw new \Exception('Invalid model data');
        }

        return $this;
    }

    protected function saveUser()
    {
        $this->user = $this->getUsersManager()
            ->save($this->getUser());

        if ($this->getUser()->isNewRecord) {
            throw new \Exception('Can not save user');
        }

        return $this;
    }

    protected function saveModel()
    {
        $this->model->user_id = $this->getUser()->id;

        if (!$this->model->save()) {
            throw new \Exception('Can not save model');
        }

        $this->getUsersManager()->saveRole($this->model);

        return $this;
    }

    protected function getUsersManager()
    {
        return $this->getApp()->usersManager;
    }
}
