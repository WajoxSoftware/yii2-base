<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Order;

class OrderSearch extends Order
{
    public function rules()
    {
        return [
            [['id', 'bill_id', 'status_id', 'delivery_status_id'], 'integer'],
            [['delivery_method'], 'safe'],
        ];
    }

    public function search($params, $sort)
    {
        $query = $this
            ->getRepository()
            ->find(Order::className());

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
            'bill_id' => $this->bill_id,
            'status_id' => $this->status_id,
            'delivery_status_id' => $this->delivery_status_id,
            'delivery_method' => $this->delivery_method,
        ]);

        $query->orderBy($sort->orders);

        return $dataProvider;
    }
}
