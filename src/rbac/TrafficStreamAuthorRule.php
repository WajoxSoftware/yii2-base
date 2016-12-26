<?php
namespace wajox\yii2base\rbac;

use yii\rbac\Rule;

class TrafficStreamAuthorRule extends Rule
{
    public $name = 'isTrafficStreamAuthor';

    public function execute($user, $item, $params)
    {
        return isset($params['stream']) ? $params['stream']->user_id == $user : false;
    }
}
