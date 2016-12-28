<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function byIdentity($id)
    {
        return $this->where($id);
    }

    public  function byAccessToken($token)
    {
        return $this->where(['access_token' => $token]);
    }

    public function byResetToken($token)
    {
    	return $this->where([
            'password_reset_token' => $token,
        ]);
    }
    
    public function byEmail($email)
    {
        return $this->where(['email' => $email]);
    }

    public function byNameOrEmail($name, $email)
    {
    	return $this->where([
            'name' => $name,
        ])->orWhere([
            'email' => $email,
        ]);
    }

    public function byEmailOrGuid($email, $guid)
    {
        return $this>where(['email' => $email])
            ->orWhere(['guid' => $guid]);
    }

    public function byIdOrGuid($id, $guid)
    {
        return $this>where(['id' => $id])
            ->orWhere(['guid' => $guid]);
    }


    public function confirmedByToken($token)
    {
        return $this->where([
                'confirmation_token' => $token,
                'confirmed_at' => 0,
            ]);
    }
}