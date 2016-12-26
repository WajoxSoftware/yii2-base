<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\models\User;

class UserActionLogSearch extends UserActionLog
{
    public function rules()
    {
        return [
            [['referal_user_id', 'user_id', 'action_type_id', 'action_item_id'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = UserActionLog::find();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'referal_user_id' => $this->referal_user_id,
            'user_id' => $this->user_id,
            'action_type_id' => $this->action_type_id,
            'action_item_id' => $this->action_item_id,
        ]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }

    public function getActionTitle()
    {
        $titles = self::getActionTypeIdList();

        if (isset($titles[$this->action_type_id])) {
            return $titles[$this->action_type_id];
        }

        return \Yii::t('app', 'All');
    }

    public function getReferalUserName()
    {
        $user = User::findOne($this->referal_user_id);

        if ($user == null) {
            return;
        }

        return $user->name;
    }

    public function getUserName()
    {
        $user = User::findOne($this->user_id);

        if ($user == null) {
            return;
        }

        return $user->name;
    }
}
