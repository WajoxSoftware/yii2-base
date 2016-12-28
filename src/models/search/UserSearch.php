<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\User;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'referal_user_id'], 'integer'],
            [['role', 'email', 'name', 'first_name', 'last_name', 'phone'], 'safe'],
        ];
    }

    public function search($params, $exceptUserIds = null, $sort = null)
    {
        $query = $this
            ->getRepository()
            ->find(User::className());

        return $this->buildDataProvider($query, $params, $exceptUserIds, $sort);
    }

    public function employeeSearch($params, $exceptUserIds = null, $sort = null)
    {
        $query = $this
            ->getRepository()
            ->find(User::className())
            ->where([
                'role' => array_keys(User::getEmployeesRoleList()),
            ]);

        return $this->buildDataProvider($query, $params, $exceptUserIds, $sort);
    }

    public function usersSearch($params, $exceptUserIds = null, $sort = null)
    {
        $query = $this
            ->getRepository()
            ->find(User::className())
            ->where([
                'role' => array_keys(User::getUsersRoleList()),
            ]);

        return $this->buildDataProvider($query, $params, $exceptUserIds, $sort);
    }

    protected function buildDataProvider($query = null, $params = [], $exceptUserIds = null, $sort = null)
    {
        if ($query == null) {
            $query = $this
                ->getRepository()
                ->find(User::className());
        }

        if ($exceptUserIds !== null) {
            $query = $query->andWhere([
                'NOT IN',
                'id',
                $exceptUserIds,
            ]);
        }

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'referal_user_id' => $this->referal_user_id,
        ]);

        $query->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        if ($sort != null) {
            $query->orderBy($sort->orders);
        }

        return $dataProvider;
    }
}
