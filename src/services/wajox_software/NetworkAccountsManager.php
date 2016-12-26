<?php
namespace wajox\yii2base\services\wajox_software;

use wajox\yii2base\components\base\object;
use wajox\yii2base\models\UserNetworkAccount;

class NetworkAccountsManager extends Object
{
    public $user = null;

    public function __construct($user = null)
    {
        $this->setUser($user);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function loadUloginToken($token)
    {
        $params = $this->getUloginData($token);

        if (sizeof($params) == 0) {
            return;
        }

        $networkAccount = $this->findAccount($params);

        if ($networkAccount) {
            return $networkAccount;
        }

        return $this->createAccount($params);
    }

    public function getUloginData($token)
    {
        $result = [];
        $url = 'http://ulogin.ru/token.php?token='
            .$token.'&host='
            .$_SERVER['HTTP_HOST'];

        $s = file_get_contents($url);
        $result = json_decode($s, true);

        if (isset($result['error'])) {
            return [];
        }

        $result['photo'] = isset($result['photo']) ? $result['photo'] : '';

        $attr = [
            'uid' => $result['identity'],
            'provider' => $result['network'],
            'params' => $result,
            'created_at' => time(),
         ];

        if ($this->getUser()) {
            $attr['user_id'] = $this->getUser()->id;
        }

        return $attr;
    }

    public function createAccount($params)
    {
        $networkAccount = $this->createObject(UserNetworkAccount::className());
        $networkAccount->setAttributes($params);

        if ($networkAccount->save()) {
            return $networkAccount;
        }

        return;
    }

    public function findAccount($params)
    {
        $networkAccount = UserNetworkAccount::find()->where([
                'uid' => $params['uid'],
                'provider' => $params['provider'],
             ])->one();

        return $networkAccount;
    }

    public function deleteAccount($id)
    {
        return UserNetworkAccount::deleteAll([
            'user_id' => $this->getUser()->id,
            'id' => $id,
        ]);
    }
}
