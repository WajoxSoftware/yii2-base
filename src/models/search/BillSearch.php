<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Bill;

class BillSearch extends Bill
{
    public function rules()
    {
        return [
            [['id', 'status_id'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = Bill::find();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
        ]);

        $query->orderBy(['created_at' => 'DESC']);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $dataProvider;
    }
}
