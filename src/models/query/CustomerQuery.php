<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;
use wajox\yii2base\models\Customer;

class CustomerQuery extends ActiveQuery
{
    public function byUniqid($id)
    {
        return $this->where(['uniqid' => $uniqId]);
    }

    public function blockedByEmailOrPhone($email, $phone)
    {
        return $this->orWhere([
	        	'email' => $email,
	        	'status_id' => Customer::STATUS_ID_BLOCKED,
	        ])
            ->orWhere([
            	'phone' => $phone,
            	'status_id' => Customer::STATUS_ID_BLOCKED,
            ]);
    }
}
