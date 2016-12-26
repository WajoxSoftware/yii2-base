<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Subscribe;

class SubscribeSearch extends Subscribe
{
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['email', 'name', 'phone'], 'safe'],
        ];
    }

    public function search($params, $sort)
    {
        $query = Subscribe::find();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        $query->orderBy($sort->orders);

        return $dataProvider;
    }
}
