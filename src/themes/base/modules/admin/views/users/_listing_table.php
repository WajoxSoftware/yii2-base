<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'email',
        'first_name',
        'last_name',
        'name',
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a(\Yii::t('app/general', 'View'), Url::toRoute(['view', 'id' => $model->id]));
                },
            ],
        ],
    ],
    'sorter' => $sort,
]);
