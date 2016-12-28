<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\GoodPartnerProgram as GoodPartnerProgramModel;

class GoodPartnerProgram extends GoodPartnerProgramModel
{
    public function rules()
    {
        return [
            [['id', 'good_id', 'partner_id'], 'integer'],
            [['fee_1_level', 'fee_2_level'], 'number'],
            [['content'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = $this
            ->getRepository()
            ->find(GoodPartnerProgramModel::className());

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
            'good_id' => $this->good_id,
            'partner_id' => $this->partner_id,
            'fee_1_level' => $this->fee_1_level,
            'fee_2_level' => $this->fee_2_level,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
