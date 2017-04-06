<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Log;
use wajox\yii2base\models\User;

class LogSearch extends Log
{
    public function rules()
    {
        return [
            [['referal_user_id', 'user_id', 'type_id', 'item_id'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = $this
            ->getRepository()
            ->find(Log::className());

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'referal_user_id' => $this->referal_user_id,
            'user_id' => $this->user_id,
            'type_id' => $this->type_id,
        ]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }

    public function getActionTitle()
    {
        $titles = self::getActionTypeIdList();

        if (isset($titles[$this->type_id])) {
            return $titles[$this->type_id];
        }

        return \Yii::t('app/general', 'All');
    }

    public function getReferalUserName()
    {
        if (!$this->referal_user_id) {
            return;
        }

        $user = $this
            ->getRepository()
            ->find(User::className())
            ->byId($this->referal_user_id)
            ->one();

        if ($user == null) {
            return;
        }

        return $user->name;
    }

    public function getUserName()
    {
        if (!$this->user_id) {
            return;
        }

        $user = $this
            ->getRepository()
            ->find(User::className())
            ->byId($this->user_id)
            ->one();

        if ($user == null) {
            return;
        }

        return $user->name;
    }
}
