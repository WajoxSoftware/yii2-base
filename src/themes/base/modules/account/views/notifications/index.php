<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = \Yii::t('app/profile', 'Nav Notifications');
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
]);
