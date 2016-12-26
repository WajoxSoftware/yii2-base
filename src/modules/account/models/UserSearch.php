<?php
namespace wajox\yii2base\modules\account\models;

use yii\data\ActiveDataProvider;
use wajox\yii2base\services\users\PrivacySettingsManager;
use wajox\yii2base\models\User;

class UserSearch extends User
{
    public $query = '';

    public function rules()
    {
        return [
            [['query'], 'safe'],
            [['query'], 'filter', 'filter' => 'strip_tags'],
            [['query'], 'filter', 'filter' => 'trim'],
        ];
    }

    public function search($params, $exceptUserIds = null)
    {
        $query = User::find()->joinWith([
                'settings' => function ($q) {
                        return $q->andWhere([
                            'search_profile' => PrivacySettingsManager::ACCESS_ALL,
                        ]);
                    },
            ]);

        if ($exceptUserIds !== null) {
            $query = $query->andWhere(['NOT IN', 'user.id', $exceptUserIds]);
        }

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'email', $this->query])
            ->orFilterWhere(['like', 'name', $this->query])
            ->orFilterWhere(['like', 'phone', $this->query]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'query' => \Yii::t('app/attributes', 'Search Query'),
        ];
    }
}
