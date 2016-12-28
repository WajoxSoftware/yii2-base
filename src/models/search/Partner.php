<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Partner as PartnerModel;

class Partner extends PartnerModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'parent_partner_id', 'subscribers_count'], 'integer'],
            [['city', 'url', 'webmoney_rub', 'field'], 'safe'],
        ];
    }

    public function search($params, $sort)
    {
        $query = $this
            ->getRepository()
            ->find(PartnerModel::className());

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
            'parent_partner_id' => $this->parent_partner_id,
            'subscribers_count' => $this->subscribers_count,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'webmoney_rub', $this->webmoney_rub])
            ->andFilterWhere(['like', 'field', $this->field]);

        $query->orderBy($sort->orders);

        return $dataProvider;
    }
}
