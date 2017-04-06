<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/profile', 'Nav Payments');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/profile', 'Nav Bills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'payments']);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_payment_item',
]);
