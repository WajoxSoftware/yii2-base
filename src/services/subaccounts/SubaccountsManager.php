<?php

namespace wajox\yii2base\services\subaccounts;

use wajox\yii2base\models\user;
use wajox\yii2base\models\UserSubaccount;
use wajox\yii2base\components\base\Object;

class SubaccountsManager extends Object
{
    public $user = null;

    public function __construct($user)
    {
        if (is_a($user, 'wajox\yii2base\models\User')) {
            $this->user = $user;
        }
    }

    public function getSubaccount($tag)
    {
        if ($this->user == null) {
            return;
        }

        $tagAttributes = $this->getTagAttributes($tag);

        $cond['user_id'] = $this->user->id;
        $cond = array_merge($cond, $tagAttributes);

        $subaccount = UserSubaccount::find()->where($cond)->one();

        if ($subaccount) {
            return $subaccount;
        }

        return $this->createSubaccount($tag);
    }

    public function getSubaccountById($id)
    {
        if ($this->user == null) {
            return;
        }

        $cond = [
            'id' => $id,
            'user_id' => $this->user->id,
        ];

        return UserSubaccount::find()->where($cond)->one();
    }

    private function createSubaccount($tag)
    {
        $subaccount = $this->createObject(UserSubaccount::className());
        $subaccount->name = $tag;
        $subaccount->user_id = $this->user->id;
        $tagsAttributes = $this->getTagAttributes($tag);

        $subaccount->setAttributes($tagsAttributes);

        if ($subaccount->save()) {
            return $subaccount;
        }

        return;
    }

    private function explodeTag($tag)
    {
        return array_filter(explode('/', $tag));
    }

    private function getTagAttributes($tag)
    {
        $tags = $this->explodeTag($tag);

        $tagAttrs = [];

        foreach ($tags as $i => $v) {
            if ($i > 3 || empty($v)) {
                break;
            }

            $name = 'tag' . ($i + 1);
            $tagAttrs[$name] = $v;
        }

        return $tagAttrs;
    }
}