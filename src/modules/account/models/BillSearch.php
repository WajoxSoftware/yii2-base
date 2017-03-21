<?php
namespace wajox\yii2base\modules\account\models;

use yii\data\ActiveDataProvider;
use wajox\yii2base\modules\payment\models\Bill;

class BillSearch extends Bill
{
    public $status_id;
    public function rules()
    {
        return [
            [['id', 'status_id'], 'integer'],
        ];
    }

    public function search($params, $user)
    {
        $query = $this
            ->getRepository()
            ->find(Bill::className())
            ->where(['user_id' => $user->id]);

        $this->load($params);

        if (!$this->validate()) {
            return $this->createObject(
                ActiveDataProvider::className(),
                [['query' => $query]]
            );
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
        ]);

        $query->orderBy(['created_at' => 'DESC']);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $dataProvider;
    }
}
