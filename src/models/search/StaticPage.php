<?php
namespace wajox\yii2base\models\search;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\StaticPage as StaticPageModel;

class StaticPage extends StaticPageModel
{
    public function rules()
    {
        return [
            [['id', 'parent_static_page_id'], 'integer'],
            [['url', 'title', 'text', 'layout'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = StaticPageModel::find();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_static_page_id' => $this->parent_static_page_id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'layout', $this->layout]);

        return $dataProvider;
    }
}
