<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/partner', 'Nav Partners');
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_partner_item',
]);
