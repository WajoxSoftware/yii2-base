<?php
namespace wajox\yii2base\modules\shop\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\modules\shop\models\Good as GoodModel;

class Good extends GoodModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at'], 'integer'],
            [['url', 'status', 'photo', 'title', 'short_description', 'description', 'tags', 'partner_program_status'], 'safe'],
            [['sum'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = $this
            ->getRepository()
            ->find(GoodModel::className());

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
            'sum' => $this->sum,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'partner_program_status', $this->partner_program_status]);

        return $dataProvider;
    }
}
