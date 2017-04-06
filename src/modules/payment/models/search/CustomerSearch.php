<?php
namespace wajox\yii2base\modules\payment\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\modules\payment\models\Customer;

class CustomerSearch extends Customer
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'status_id'], 'integer'],
            [['email', 'full_name', 'phone'], 'safe'],
        ];
    }

    public function search($params, $sort)
    {
        $query = $this
            ->getRepository()
            ->find(Customer::className());

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
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        $query->orderBy($sort->orders);

        return $dataProvider;
    }
}
