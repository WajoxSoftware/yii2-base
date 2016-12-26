<?php
namespace wajox\yii2base\services\shop;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Customer;
use wajox\yii2base\services\users\UsersManager;
use wajox\yii2base\components\base\Object;

class CustomerBuilder extends Object
{
    public $user = null;
    public $customer = null;

    public function __construct($user = null)
    {
        $this->customer = $this->createObject(Customer::className());
        $this->loadUser($user);
    }

    public function validate()
    {
        if ($this->customer->isBlocked) {
            return false;
        }

        $exists = Customer::find()->blockedByEmailOrPhone(
            $this->customer->email,
            $this->customer->phone
        )->exists();

        if ($exists) {
            return false;
        }

        return true;
    }

    public function loadRequest($request)
    {
        $visitpr = $this->getApp()->visitor;
        $this->customer->load($request->post());
        $this->customer->created_at = time();
        $this->setVisitorData();

        return $this;
    }

    public function loadAttributes($attributes)
    {
        $this->customer->setAttributes($attributes);
        $this->customer->created_at = time();
        $this->setVisitorData();

        return $this;
    }

    public function setVisitorData()
    {
        $visitor = $this->getApp()->visitor;

        $this->customer->user_id = $this->user == null ? 0 : $this->user->id;
        $this->customer->referal_user_id = $visitor->referalId;
        $this->customer->guid = $visitor->guid;

        return $this;
    }

    public function loadUser($user)
    {
        if ($user == null) {
            return $this;
        }

        $this->customer->full_name = $user->fullName;
        $this->customer->email = $user->email;
        $this->customer->user_id = $user->id;
        $this->user = $user;

        return $this;
    }

    public function setUser($user)
    {
        if ($user == null) {
            return $this;
        }

        $this->user = $user;
        $this->customer->user_id = $user->id;

        return $this;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function save()
    {
        if ($this->user == null) {
            $user = $this->findOrCreateUser(
                $this->getCustomer()
            );

            $this->setUser($user);
        }

        $uniqIdStr = $this->customer->email . $this->customer->phone . $this->customer->fullAddress . $this->customer->fullName;

        $uniqId = md5($uniqIdStr);

        $this->customer->uniqid = $uniqId;

        if (($customer = $this->findCustomerByUniqid($uniqId)) != null) {
            $this->customer = $customer;

            return true;
        }

        if (!$this->customer->validate()) {
            return false;
        }

        return $this->customer->save();
    }

    public function findCustomerByUniqid($uniqId)
    {
        $model = Customer::find()->byUniqid($uniqId)->one();

        if ($model == null) {
            return null;
        }

        if ($model->email != $this->customer->email
            || $model->phone != $this->customer->phone
        ) {
            return null;
        }

        return $model;
    }

    public function findOrCreateUser($customer)
    {
        return $this->getUsersManager()->findOrCreate($customer->email, $customer->email);
    }

    protected function getUsersManager()
    {
        return $this->getDependency(UsersManager::className());
    }
}
