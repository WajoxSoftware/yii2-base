<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function byIdentity($id)
    {
        return $this->where(['id' => intval($id)]);
    }

    public  function byAccessToken($token)
    {
        return $this->where([
            'access_token' => htmlspecialchars($token),
        ]);
    }

    public function byResetToken($token)
    {
    	return $this->where([
            'password_reset_token' => htmlspecialchars($token),
        ]);
    }
    
    public function byEmail($email)
    {
        return $this->where([
            'email' => htmlspecialchars($email),
        ]);
    }

    public function byNameOrEmail($name, $email)
    {
    	return $this->where([
            'name' => htmlspecialchars($name),
        ])->orWhere([
            'email' => htmlspecialchars($email),
        ]);
    }

    public function byEmailOrGuid($email, $guid)
    {
        return $this>where([
            'email' => htmlspecialchars($email),
        ])->orWhere([
            'guid' => htmlspecialchars($guid),
        ]);
    }

    public function byIdOrGuid($id, $guid)
    {
        return $this>where(['id' => intval($id)])
            ->orWhere(['guid' => htmlspecialchars($guid)]);
    }


    public function confirmedByToken($token)
    {
        return $this->where([
                'confirmation_token' => htmlspecialchars($token),
                'confirmed_at' => 0,
            ]);
    }
}