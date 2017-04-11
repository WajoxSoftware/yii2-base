<?php
namespace wajox\yii2base\modules\payment\models\query;

use wajox\yii2base\components\db\ActiveQuery;
use wajox\yii2base\modules\payment\models\Customer;

class CustomerQuery extends ActiveQuery
{
    public function byUniqid(string $uniqId): CustomerQuery
    {
        return $this->where([
            'uniqid' => htmlspecialchars($uniqId),
        ]);
    }

    public function blockedByEmailOrPhone($email, $phone): CustomerQuery
    {
        return $this->orWhere([
                'email' => htmlspecialchars($email),
                'status_id' => intval(Customer::STATUS_ID_BLOCKED),
            ])
            ->orWhere([
                'phone' => htmlspecialchars($phone),
                'status_id' => intval(Customer::STATUS_ID_BLOCKED),
            ]);
    }
}
