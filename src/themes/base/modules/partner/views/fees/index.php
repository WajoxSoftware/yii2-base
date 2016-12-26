<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/partner', 'Nav Fees');
$this->params['breadcrumbs'][] = $this->title;
echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
]);
