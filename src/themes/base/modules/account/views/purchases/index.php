<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/profile', 'Nav Purchases');
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
]);
